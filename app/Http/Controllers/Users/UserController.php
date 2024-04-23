<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\{User, CompanyType, Service, Project, ContactUs, DeleteAccountRequest, Review, OngoingProject, Offer, SavedCompany};
use App\Http\Requests\{Users, Home};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // user project published count

    public function project_count(Users $request)
    {
        $user_id = $request->user_id;
        $user = User::find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' =>  [],
            ];
            return response()->json($data, 200);
        }

        $projects = Project::where('user_id', $user_id)->whereIn('status', [1, 2, 3])->count();

        // on the basis of free projet offer provided by Probau
        $offer =  Offer::where('type', 1)->exists();

        $data = [
            'message' => 'Project Count',
            'status' => true,
            'data' => [
                'projects_count' => $projects,
                'offer' => $offer
            ],
        ];
        return response()->json($data, 200);
    }

    // user Home 
    public function user_home(Home $request)
    {
        $state = $request->state;
        $user_id = $request->user_id;
        $page_no = $request->page_no;
        $user = User::find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        $project = Project::where('user_id', $user_id)->get();
        $serviceArray = [];
        $companyTypeArray = [];

        foreach ($project as $singleProject) {
            $services = $singleProject->services;
            $company_type = $singleProject->company_type;

            // Merge the values into respective arrays
            $serviceArray = array_merge($serviceArray, $services);
            $companyTypeArray = array_merge($companyTypeArray, $company_type);
        }





        $userServices = array_unique($serviceArray);
        $userCompanyType = array_unique($companyTypeArray);
        if ($state == 1) {

            return $this->recommended_companies($user_id, $page_no, $userServices, $userCompanyType);
        } elseif ($state == 2) {

            return $this->saved_companies($user_id, $page_no);
        } elseif ($state == 3) {

            $lat = $user->lat;
            $longi = $user->long;
            return $this->nearby_companies($user_id, $page_no, $lat, $longi);
        } else {

            return $this->best_rated_companies($user_id, $page_no);
        }
    }


    //  user home data of recommended companies
    public function recommended_companies($user_id, $page_no, $userServices, $userCompanyType)
    {
        $perPage = 10;

        $companies = User::with('company_type.services')->select('id', 'name', 'profile_pic', 'description', 'company_type', 'services')
            ->where('id', '!=', $user_id)
            ->where('user_type', 'company')
            ->where(function ($query) use ($userServices) {
                foreach ($userServices as $userService) {
                    $query->orWhere('services', 'like', '%' . $userService . '%');
                }
            })
            ->skip(($page_no - 1) * $perPage)
            ->take($perPage)
            ->get();

        foreach ($companies as $company) {

            // total projects count
            // get those projects  which company has completed working with other private user/company
            $completed_Projects = $this->totalCompletedProjects($company->id);
            $company['totalProjects'] = count($completed_Projects);

            // total reviews count
            $reviews = Review::where('company_id', $company->id)->get();
            $averageRating = round($reviews->avg('rating'), 1);
            $totalRating = $reviews->count();
            $company['avgRating'] = $averageRating;
            $company['totalRating'] = $totalRating;

            // get saved details
            $saved = SavedCompany::where([
                'user_id' => $user_id,
                'company_id' => $company['id'],
            ])->first();
            if ($saved) {
                $company['saved'] = 1;
            } else {
                $company['saved'] = 0;
            }
            $company['distance'] = '0';
        }
        $totalCompanies = User::where('id', '!=', $user_id)
            ->where('user_type', 'company')
            ->where(function ($query) use ($userServices) {
                foreach ($userServices as $userService) {
                    $query->orWhere('services', 'like', '%' . $userService . '%');
                }
            })
            ->count();

        if ($totalCompanies > 0) {
            return $this->return_companies_found($companies, ceil($totalCompanies / $perPage));
        } else {
            return $this->return_not_companies_found();
        }
    }

    //  user home data of saved companies
    public function saved_companies($user_id, $page_no)
    {
        $perPage = 10;
        $companies = SavedCompany::where('user_id', $user_id)->skip(($page_no - 1) * $perPage)
            ->take($perPage)->get();
        $companyCollection = collect();
        foreach ($companies as $d) {
            $company = User::with('company_type.services')->where([
                'id' => $d->company_id,
                'user_type' => 'company',
            ])->select('id', 'name', 'profile_pic', 'description', 'company_type', 'services')->first();

            // total projects count
            // get those projects  which company has completed working with other private user/company
            $completed_Projects = $this->totalCompletedProjects($d->company_id);
            $company['totalProjects'] = count($completed_Projects);

            // total reviews count
            $reviews = Review::where('company_id', $d->company_id)->get();
            $averageRating = round($reviews->avg('rating'), 1);
            $totalRating = $reviews->count();
            $company['avgRating'] = $averageRating;
            $company['totalRating'] = $totalRating;

            // get saved details
            $saved = SavedCompany::where([
                'user_id' => $user_id,
                'company_id' => $d['company_id'],
            ])->first();
            if ($saved) {
                $company['saved'] = 1;
            } else {
                $company['saved'] = 0;
            }
            $company['distance'] = '0';
            $companyCollection->push($company);
        }
        $totalCompanies = SavedCompany::where('user_id', $user_id)
            ->count();
        if (count($companies) > 0) {
            return $this->return_companies_found($companyCollection, ceil($totalCompanies / $perPage));
        } else {
            return $this->return_not_companies_found();
        }
    }

    //  user home data of nearby companies
    public function nearby_companies($user_id, $page_no, $lat, $longi)
    {
        if ($lat == "" || $longi == "") {
            return $this->return_not_companies_found();
        }
        $perPage = 10;
        $radius = 20;
        $companies = User::with('company_type.services')->select('id', 'name', 'profile_pic', 'description', 'company_type', 'services')
            ->where('id', '!=', $user_id)
            ->where('user_type', 'company')
            ->selectRaw(
                'CAST(ROUND((6371 * acos(cos(radians(?)) *
                cos(radians(lat)) *
                cos(radians(`long`) - radians(?)) +
                sin(radians(?)) *
                sin(radians(lat)))), 4) AS CHAR) AS distance',
                [$lat, $longi, $lat]
            )
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->skip(($page_no - 1) * $perPage)
            ->take($perPage)
            ->get();

        foreach ($companies as $d) {
            // total projects count
            // get those projects  which company has completed working with other private user/company
            $completed_Projects = $this->totalCompletedProjects($d->id);
            $d['totalProjects'] = count($completed_Projects);

            // total reviews count
            $reviews = Review::where('company_id', $d->id)->get();
            $averageRating = round($reviews->avg('rating'), 1);
            $totalRating = $reviews->count();
            $d['avgRating'] = $averageRating;
            $d['totalRating'] = $totalRating;

            // get saved details
            $saved = SavedCompany::where([
                'user_id' => $user_id,
                'company_id' => $d['id'],
            ])->first();
            if ($saved) {
                $d['saved'] = 1;
            } else {
                $d['saved'] = 0;
            }
        }

        $totalCompanies = User::select('id', 'name', 'profile_pic', 'description', 'company_type', 'services')
            ->where('id', '!=', $user_id)
            ->where('user_type', 'company')
            ->selectRaw(
                'ROUND((6371 * acos(cos(radians(?)) *
                cos(radians(lat)) *
                cos(radians(`long`) - radians(?)) +
                sin(radians(?)) *
                sin(radians(lat)))), 4) AS distance',
                [$lat, $longi, $lat]
            )
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->count();

        if ($totalCompanies > 0) {
            return $this->return_companies_found($companies, ceil($totalCompanies / $perPage));
        } else {
            return $this->return_not_companies_found();
        }
    }


    //  user home data of best rated companies 
    public function best_rated_companies($user_id, $page_no)
    {
        $perPage = 10;

        $topRatedCompanies = DB::table('reviews')
            ->select('company_id', DB::raw('AVG(rating) as average_rating'))
            ->groupBy('company_id')
            ->where('company_id', '!=', $user_id)
            ->orderBy('average_rating', 'desc')
            ->orderBy('company_id', 'asc')
            ->skip(($page_no - 1) * $perPage)
            ->take($perPage)
            ->get();
        // If you want to get the list of company IDs of top-rated companies
        $topRatedCompanyIds = $topRatedCompanies->pluck('company_id');
        $companyCollection = collect();
        foreach ($topRatedCompanyIds as $company_id) {
            $company = User::with('company_type.services')->where([
                'id' => $company_id,
                'user_type' => 'company',
            ])->select('id', 'name', 'profile_pic', 'description', 'company_type', 'services')->first();
            if ($company) {
                // total projects count
                // get those projects  which company has completed working with other private user/company
                $completed_Projects = $this->totalCompletedProjects($company_id);
                $company['totalProjects'] = count($completed_Projects);

                // total reviews count
                $reviews = Review::where('company_id', $company_id)->get();
                $averageRating = round($reviews->avg('rating'), 1);
                $totalRating = $reviews->count();
                $company['avgRating'] = $averageRating;
                $company['totalRating'] = $totalRating;

                // get saved details
                $saved = SavedCompany::where([
                    'user_id' => $user_id,
                    'company_id' => $company_id,
                ])->first();
                if ($saved) {
                    $company['saved'] = 1;
                } else {
                    $company['saved'] = 0;
                }
                $company['distance'] = '0';
                $companyCollection->push($company);
            }
        }
        $totalCompanies = DB::table('reviews')
            ->select('company_id', DB::raw('AVG(rating) as average_rating'))
            ->groupBy('company_id')
            ->havingRaw('AVG(rating) >=4.5')
            ->where('company_id', '!=', $user_id)
            ->count();
        if (count($topRatedCompanyIds) > 0) {
            return $this->return_companies_found($companyCollection, ceil($totalCompanies / $perPage));
        } else {
            return $this->return_not_companies_found();
        }
    }



    public function return_companies_found($companies, $totalPages)
    {
        $data = [
            'message' => 'Companies Found',
            'status' => true,
            'data' => $companies,
            'total_pages' => $totalPages
        ];

        return response()->json($data, 200);
    }

    public function return_not_companies_found()
    {
        $data = [
            'message' => 'Companies not Found',
            'status' => true,
            'data' => [],
            'total_pages' => 0
        ];

        return response()->json($data, 200);
    }

    public function totalCompletedProjects($company_id)
    {
        $completed_projects = OngoingProject::where([
            'company_id' => $company_id,
        ])->pluck('project_id')->toArray();

        return $completed_projects;
    }



    // data submission for contact us and delete account request 


    public function contact_us_form(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'message' => $request->input('message'),
        ];

        $create = ContactUs::create($data);

        return response()->json(['message' => 'Form submitted successfully']);
    }

    public function delete_account_form(Request $request)
    {
        $check = User::where('email', $request->input('email'))->first();

        if ($check == null) {
            return response()->json(['error' => 'We do not have account associated with this email address'], 400);
        }

        $data = [
            'email' => $request->input('email'),
            'reason' => $request->input('reason'),
        ];

        $create = DeleteAccountRequest::create($data);

        return response()->json(['message' => 'Form submitted successfully']);
    }
}
