<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\{User, CompanyProject, CompanyProjectImage, DeleteAccountRequest ,Project, CompanyType, Service, Review, OngoingProject, CompanyUser, Subscription, SubscriptionPlan, PlanCharge, ProjectPayment};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    public  function private_users()
    {
        $users = User::where('user_type', 'user')->get();
        return view('frontend.PrivateUser', compact('users'));
    }
    public function getUsers(Request $request)
    {
        $searchTerm = $request->input('search');
        $userCount = User::where('user_type', 'user')->count();
        $query = User::where('user_type', 'user');

        if ($searchTerm) {
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }
        $sortingOption = $request->input('sorting'); // Get the sorting option from the request

        if ($sortingOption === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sortingOption === 'earliest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        $user = $query->paginate(10);
        foreach ($user as $row) {
            $row->registration_date = $row->created_at->format('j \\ F Y');
            $project_count = Project::where(['user_id' => $row->id, 'project_type' => 'user'])->count();
            $row->project_count = $project_count;
        }
        return response()->json(['userCount' => $userCount, 'users' => $user]);
    }

    public function user_detail(Request $request, $id)
    {
        $user = User::with('Projects')->where('id', $id)->first();
        $projects = Project::with('company_types.services')->where('user_id', $id)->get();
        foreach ($projects as $project) {
           
            $project['start_time'] = Carbon::parse($project->created_at)->format('M d, Y') ?? "";
            if ($project['status'] == 3) {
                $project['end_time'] = Carbon::parse($project->updated_at)->format('M d, Y') ?? "";
            } else {
                $project['end_time'] = "";
            }
        }

        // check if user has requested to deleted account 

        $deleteRequest = DeleteAccountRequest::where('email', $user->email)->exists();
        $graphData = $this->user_project_grapgh_data($id);
        $response = [
            'user' => $user,
            'deleteRequest' => $deleteRequest,
            'projects' => $projects,
            'graph_data' => $graphData
        ];
        return view('frontend.UserDetail', compact('response', 'id'));
    }

    public function user_project_grapgh_data($user_id)
    {

        $current_month_name = Carbon::now()->isoFormat('MMM');
        $second_month_name = Carbon::now()->subMonthsNoOverflow(1)->isoFormat('MMM');
        $third_month_name = Carbon::now()->subMonthsNoOverflow(2)->isoFormat('MMM');
        $fourth_month_name = Carbon::now()->subMonthsNoOverflow(3)->isoFormat('MMM');
        $five_month_name = Carbon::now()->subMonthsNoOverflow(4)->isoFormat('MMM');
        $six_month_name = Carbon::now()->subMonthsNoOverflow(5)->isoFormat('MMM');
        $Months = [
            $six_month_name,
            $five_month_name,
            $fourth_month_name,
            $third_month_name,
            $second_month_name,
            $current_month_name,
        ];

        // Project graph Data

        $projects_per_month = 6;
        $monthly_projects = [];

        for ($i = 0; $i < $projects_per_month; $i++) {
            $month = Carbon::now()->subMonths($i);
            $projects = Project::where([
                ['user_id', $user_id]
            ])->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();

            $monthly_projects[] = $projects;
        }

        // Reverse the array to have the latest record at the last index
        $monthly_projects = array_reverse($monthly_projects);

        $current_month_projects = $monthly_projects[5];
        $total_projects = array_sum($monthly_projects);
        // Calculate the percentage
        if ($total_projects > 0) {
            $this_month_projects_percentage = round(($current_month_projects / $total_projects) * 100, 0);
        } else {
            $this_month_projects_percentage = 0;
        }

        $data = [
            'months' => $Months,
            'months_projects' => $monthly_projects,
            'this_month_projects_percentage' => $this_month_projects_percentage
        ];
        return $data;
    }

    public function project_against_user_id(Request $request)
    {
        $searchTerm = $request->input('search');
        $userCount = Project::where('user_id', $request->id)->count();
        $query = Project::with('company_types')->where('user_id', $request->id);

        if ($searchTerm) {
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }
        $sortingOption = $request->input('sorting'); // Get the sorting option from the request

        if ($sortingOption === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sortingOption === 'earliest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        $user = $query->paginate(5);
        foreach ($user as $row) {
            $row->uploaded_at = $row->created_at->format('F \\ j, Y');
        }
        return response()->json(['userCount' => $userCount, 'users' => $user]);
    }
    public function payment_history(Request $request, $id)
    {
        $payments = ProjectPayment::with('projects')->where('user_id', $id)->paginate(10);
        foreach ($payments as $payment) {
            $projects = $payment->projects;

            $company_type = $projects->company_type;
            $companyTypeData = [];
            foreach ($company_type as $row) {
                $data = CompanyType::where('id', $row)->select('id', 'name')->first();
                $companyTypeData[] = $data;
            }
            $projects->company_type = $companyTypeData;
            $services = $projects->services;
            $serviceData = [];
            foreach ($services as $row) {
                $data = Service::where('id', $row)->select('id', 'name')->first();
                $serviceData[] = $data;
            }
            $projects->services = $serviceData;
        }
        return view('frontend.UserPaymentHistory', compact('payments'));
    }

    public function project_by_project_id(Request $request, $id)
    {
        $project_id = $id;
        $project = Project::with('company_types.services')->find($project_id);


        // start and end time
        $project->start_time = Carbon::parse($project->created_at)->format('M d, Y') ?? "";
        if ($project->status == 3) {
            $project->end_time = Carbon::parse($project->updated_at)->format('M d, Y') ?? "";
        } else {
            $project->end_time = "";
        }

        // dd($project);
        return view('frontend.ProjectDetail', compact('project'));
    }


    public  function company_users()
    {
        $users = User::where('user_type', 'company')->get();
        return view('frontend.CompanyUsers', compact('users'));
    }

    public function get_company_users(Request $request)
    {
        $searchTerm = $request->input('search');
        $userCount = User::where('user_type', 'company')->count();
        $query = User::with('company_type')->where('user_type', 'company');

        if ($searchTerm) {
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }
        $sortingOption = $request->input('sorting'); // Get the sorting option from the request

        if ($sortingOption === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sortingOption === 'earliest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        $user = $query->paginate(10);
        foreach ($user as $row) {
            $project_count = Project::where(['user_id' => $row->id, 'project_type' => 'company'])->count();
            $row->project_count = $project_count;
        }
        return response()->json(['userCount' => $userCount, 'users' => $user]);
    }

    public function company_detail(Request $request, $id)
    {
        $user = User::with('Projects', 'company_types.services')->where('id', $id)->first();
        $company_type = CompanyType::where('id', $user->company_type)->select('id', 'name')->first();
       
        $completed_Projects = $this->totalCompletedProjects($id);
        $user->totalProjects = count($completed_Projects);

        // total reviews count
        $reviews = Review::where('company_id', $user->id)->get();
        $averageRating = round($reviews->avg('rating'), 1);
        $totalRating = $reviews->count();
        $user->avgRating = $averageRating;
        $user->totalRating = $totalRating;

        $projects = Project::where('user_id', $id)->get();
        foreach ($projects as $project) {
           
            $project->start_time = Carbon::parse($project->created_at)->format('M d, Y') ?? "";
            if ($project->status == 3) {
                $project->end_time = Carbon::parse($project->updated_at)->format('M d, Y') ?? "";
            } else {
                $project->end_time = "";
            }
        }
        $deleteRequest = DeleteAccountRequest::where('email', $user->email)->exists();

        $response = [
            'user' => $user,
            'deleteRequest' => $deleteRequest,
            'projects' => $projects,
        ];

        // dd($user);
        return view('frontend.CompanyDetail', compact('response', 'id'));
    }

    public function company_detail_projects(Request $request, $id)
    {
        $user = User::with('Projects')->where('id', $id)->first();
        $company_type = CompanyType::where('id', $user->company_type)->select('id', 'name')->first();
       
        $completed_Projects = $this->totalCompletedProjects($id);
        $user->totalProjects = count($completed_Projects);

        // total reviews count
        $reviews = Review::where('company_id', $user->id)->get();
        $averageRating = round($reviews->avg('rating'), 1);
        $totalRating = $reviews->count();
        $user->avgRating = $averageRating;
        $user->totalRating = $totalRating;

        $projects = Project::where('user_id', $id)->get();
        foreach ($projects as $project) {
           
            $project->start_time = Carbon::parse($project->created_at)->format('M d, Y') ?? "";
            if ($project->status == 3) {
                $project->end_time = Carbon::parse($project->updated_at)->format('M d, Y') ?? "";
            } else {
                $project->end_time = "";
            }
        }
        $deleteRequest = DeleteAccountRequest::where('email', $user->email)->exists();

        $response = [
            'user' => $user,
            'deleteRequest' => $deleteRequest,
            'projects' => $projects,
        ];

        // dd($user);
        return view('frontend.CompanyDetailProjects', compact('response', 'id'));
    }
    public function company_reviews(Request $request, $id)
    {
        $user = User::with('Projects')->where('id', $id)->first();
        $completed_Projects = $this->totalCompletedProjects($id);
        $user->totalProjects = count($completed_Projects);

        // total reviews count
        $reviews = Review::where('company_id', $user->id)->get();
        $averageRating = round($reviews->avg('rating'), 1);
        $totalRating = $reviews->count();
        $user->avgRating = $averageRating;
        $user->totalRating = $totalRating;

        $reviews = Review::where('company_id', $id)->get();
        foreach ($reviews as $review) {
            $reviewer = User::find($review->user_id);
            $project = Project::find($review->project_id);
            $review->user_name = $reviewer->name;
            $review->profile_pic = $reviewer->profile_pic;
            $review->project_name = $project->name;
        }
        $deleteRequest = DeleteAccountRequest::where('email', $user->email)->exists();

        $response = [
            'user' => $user,
            'deleteRequest' => $deleteRequest,
            'reviews' => $reviews,
        ];
        // dd($reviews);

        // dd($user);
        return view('frontend.CompanyReviews', compact('response', 'id'));
    }

    public function company_in_charges(Request $request, $id)
    {
        $user = User::with('Projects')->where('id', $id)->first();
        $completed_Projects = $this->totalCompletedProjects($id);
        $user->totalProjects = count($completed_Projects);

        // total reviews count
        $reviews = Review::where('company_id', $user->id)->get();
        $averageRating = round($reviews->avg('rating'), 1);
        $totalRating = $reviews->count();
        $user->avgRating = $averageRating;
        $user->totalRating = $totalRating;
        $company_users = CompanyUser::where('company_id', $id)->get();
        $deleteRequest = DeleteAccountRequest::where('email', $user->email)->exists();

        $response = [
            'user' => $user,
            'deleteRequest' => $deleteRequest,
            'company_users' => $company_users,
        ];

        return view('frontend.CompanyInCharges', compact('response', 'id'));
    }

    public function company_past_projects(Request $request, $id)
    {
        $user = User::with('Projects')->where('id', $id)->first();
        $completed_Projects = $this->totalCompletedProjects($id);
        $user->totalProjects = count($completed_Projects);

        // total reviews count
        $reviews = Review::where('company_id', $user->id)->get();
        $averageRating = round($reviews->avg('rating'), 1);
        $totalRating = $reviews->count();
        $user->avgRating = $averageRating;
        $user->totalRating = $totalRating;
        $past_projects = CompanyProject::with('project_sub_images')->where('company_id', $id)->get();
        $deleteRequest = DeleteAccountRequest::where('email', $user->email)->exists();

        $response = [
            'user' => $user,
            'deleteRequest' => $deleteRequest,
            'company_users' => $past_projects,
        ];

        return view('frontend.CompanyDetailPastProject', compact('response', 'id'));
    }

    public function past_project_detail(Request $request, $id)
    {
        $project =  CompanyProject::with('project_sub_images')->where('id', $id)->first();
        return view('frontend.PastProjectDetail', compact('project'));
    }
    public function company_subscription(Request $request, $id)
    {
        $user = User::with('Projects')->where('id', $id)->first();
        $completed_Projects = $this->totalCompletedProjects($id);
        $user->totalProjects =count($completed_Projects);
        // total reviews count
        $reviews = Review::where('company_id', $user->id)->get();
        $averageRating = round($reviews->avg('rating'), 1);
        $totalRating = $reviews->count();
        $user->avgRating = $averageRating;
        $user->totalRating = $totalRating;

        $subscriptions = Subscription::where([
            'user_id' => $id,
        ])->get();

        foreach ($subscriptions as $subscription) {
            $plan_detail = SubscriptionPlan::find($subscription->plan_id);

            $subscription->plan_detail = $plan_detail;

            $charges_detail = PlanCharge::where('id', $subscription->charges_id)->first();
            $subscription->charges_detail = $charges_detail;
        }
        $deleteRequest = DeleteAccountRequest::where('email', $user->email)->exists();

        $response = [
            'user' => $user,
            'deleteRequest' => $deleteRequest,
            'subscriptions' => $subscriptions,
        ];
        return view('frontend.CompanySubscription', compact('response', 'id'));
    }

    public function totalCompletedProjects($company_id)
    {
        $completed_projects = OngoingProject::where([
            'company_id' => $company_id,
        ])->pluck('project_id')->toArray();

        return $completed_projects;
    }



    public function delete_account(Request $request, $id)
    {

        $user = User::find($id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $data = DeleteAccountRequest::where('email', $user->email)->delete();
        $success = $user->delete();
        return redirect()->route('Requests');

    }

}
