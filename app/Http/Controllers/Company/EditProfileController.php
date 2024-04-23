<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\{User, UserCompanyServices, UserCompanyType, CompanyProject, CompanyProjectImage, RecentSearch, CompanyUser, CompanyType, Service, Project, SavedCompany, Review, OngoingProject, ProjectRequest, ProjectServices};
use App\Http\Requests\{AddCompanyProject, AddCompanyUser, EditProfile, EditService, SocailEditProfile, ComapnyProfile, CompanyGet, MyRequests, RecentSearches};
use App\Models\SavedProject;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function Laravel\Prompts\select;

class EditProfileController extends Controller
{

    // my profile 
    public function my_profile(EditProfile $request)
    {

        $user_id = $request->user_id;
        $user = User::with('company_type.services')->find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }


        // total projects count
        // get those projects  which company has completed working with other private user/company
        $completed_Projects = $this->totalCompletedProjects($user_id);
        $user->totalProjects = count($completed_Projects);


        // total reviews count
        $reviews = Review::where('company_id', $user->id)->get();
        $averageRating = round($reviews->avg('rating'), 1);
        $totalRating = $reviews->count();
        $user->avgRating = $averageRating;
        $user->totalRating = $totalRating;
        return response()->json(
            [
                'message' => 'User Fetched Successfully',
                'status' => true,
                'data' => $user
            ],
            200
        );
    }

    // Company details data
    public function in_charges(ComapnyProfile $request)
    {
        $company_id = $request->company_id;
        $page_no = $request->page_no;
        $company = User::find($company_id);
        if ($company == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        // get paginated data  

        $perPage = 6;

        $offset = ($page_no - 1) * $perPage;
        $get_in_charges = CompanyUser::skip($offset)->where('company_id', $company_id)->take($perPage)->get();

        $totalPages = ceil(CompanyUser::where(['company_id' => $company_id])->count() / $perPage);
        if (count($get_in_charges) > 0) {
            return response()->json(
                [
                    'message' => 'In Charges found succesfully',
                    'status' => true,
                    'data' => [
                        'page_data' => $get_in_charges,
                        'total_pages' => $totalPages
                    ]
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'No Data Found',
                    'status' => true,
                    'data' => [
                        'page_data' => [],
                        'total_pages' => 0
                    ]
                ],
                200
            );
        }
    }

    // Company details data
    public function projects(ComapnyProfile $request)
    {
        $company_id = $request->company_id;
        $page_no = $request->page_no;
        $company = User::find($company_id);
        if ($company == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        // get those projects  which company has completed working with other private user/company
        $completed_projects = $this->totalCompletedProjects($company_id);
        // get paginated data  
        $perPage = 6;

        $offset = ($page_no - 1) * $perPage;
        $projects = Project::skip($offset)->where('status', 3)->whereIn('id', $completed_projects)->take($perPage)->get();
        foreach ($projects as $project) {
            $company_type = $project->company_type;
            $companyTypeData = [];
            foreach ($company_type as $row) {
                $data = CompanyType::where('id', $row)->select('id', 'name')->first();
                $companyTypeData[] = $data;
            }
            $project->company_type = $companyTypeData;
            $serviceData = ProjectServices::where(['project_id' => $project->id])->select('service_id AS id')->get();
            foreach ($serviceData as $r) {
                $service_name = Service::where('id', $r->id)->first();
                $r->name = $service_name->name;
            }
            $project->services = $serviceData;
        }
        $totalPages = ceil(count($completed_projects) / $perPage);
        if (count($projects) > 0) {
            return response()->json(
                [
                    'message' => 'Projects found succesfully',
                    'status' => true,
                    'data' => [
                        'page_data' => $projects,
                        'total_pages' => $totalPages
                    ]
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'No Data Found',
                    'status' => true,
                    'data' => [
                        'page_data' => [],
                        'total_pages' => 0
                    ]
                ],
                200
            );
        }
    }

    // Company details data
    public function reviews(ComapnyProfile $request)
    {
        $company_id = $request->company_id;
        $page_no = $request->page_no;
        $company = User::find($company_id);
        if ($company == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        // get paginated data  

        $perPage = 6;

        $offset = ($page_no - 1) * $perPage;
        $reviews = Review::skip($offset)->where('company_id', $company_id)->take($perPage)->get()
            ->map(function ($review) {
                $review->since = Carbon::parse($review->created_at)->diffForHumans();
                return $review;
            });;
        foreach ($reviews as $review) {
            $user = User::find($review->user_id);
            $project = Project::find($review->project_id);
            $review->user_name = $user->name;
            $review->profile_pic = $user->profile_pic;
            $review->project_name = $project->name;
        }
        $totalPages = ceil(Review::where(['company_id' => $company_id])->count() / $perPage);
        if (count($reviews) > 0) {
            return response()->json(
                [
                    'message' => 'Reviews fetched succesfully',
                    'status' => true,
                    'data' => [
                        'page_data' => $reviews,
                        'total_pages' => $totalPages
                    ]
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'No Data Found',
                    'status' => true,
                    'data' => [
                        'page_data' => [],
                        'total_pages' => 0
                    ]
                ],
                200
            );
        }
    }
    // update/add user profile image 
    public function edit_profile_image(Request $request)
    {

        $user = User::find(request('user_id'));
        // if no user found in database
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        // decode the base64 image
        $base64File = request('profile_pic');

        // store orignal image
        $fileData = base64_decode($base64File);

        $name = 'users_profile/' . Str::random(15) . '.png';

        Storage::put('public/' . $name, $fileData);


        // update the user's profile_pic
        $user->profile_pic = $name;
        $user->save();
        //return a response as json assuming you are building a restful API
        return response()->json(
            [
                'message' => 'Profile picture updated',
                'status' => true,
                'data' => [
                    'profile_pic' => $name,
                ],
            ],
            200
        );
    }
    // get all company users 

    public function get_company_users(Request $request)
    {

        $user = User::find(request('company_id'));
        if ($user == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $company_users = CompanyUser::where('company_id', request('company_id'))->get();
        if (count($company_users) > 0) {
            return response()->json(
                [
                    'message' => 'Company Users',
                    'status' => true,
                    'data' => $company_users
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'No Company Users Found',
                    'status' => true,
                    'data' => []
                ],
                200
            );
        }
    }

    // Add Company Users
    public function company_users(AddCompanyUser $request)
    {

        $user = User::find(request('company_id'));
        if ($user == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        $base64File = request('image');

        // store orignal image
        $fileData = base64_decode($base64File);

        $name = 'company_user/' . Str::random(15) . '.png';

        Storage::put('public/' . $name, $fileData);

        $data = [
            'company_id' => $request->company_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'image' => $name,
            'designation' => $request->designation,
            'joining_date' => $request->joining_date,
        ];
        $company_user = CompanyUser::create($data);
        $company_user = CompanyUser::where('id', $company_user->id)->first();
        if ($company_user) {
            return response()->json(
                [
                    'message' => 'Added Successfully',
                    'status' => true,
                    'data' => $company_user
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'Failed to add user',
                    'status' => true,
                    'data' => []
                ],
                200
            );
        }
    }

    // Delete Company user
    public function company_user_delete(Request $request)
    {

        $user = CompanyUser::where('id', request('user_id'))->first();
        if ($user) {

            $success = $user->delete();
            if ($success) {
                return response()->json(
                    [
                        'message' => 'User deleted successfully',
                        'status' => true,
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'message' => 'Unable to delete user',
                        'status' => false,
                    ],
                    200
                );
            }
        } else {
            $data = [
                'message' => 'No User found',
                'status' => false,
            ];

            return response($data, 200);
        }
    }

    // Add Company project
    public function add_company_project(AddCompanyProject $request)
    {

        $user = User::find(request('company_id'));
        if ($user == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        $base64File = request('image');

        // store orignal image
        $fileData = base64_decode($base64File);

        $name = 'company_project_images/' . Str::random(15) . '.png';

        Storage::put('public/' . $name, $fileData);

        $data = [
            'company_id' => $request->company_id,
            'name' => $request->name,
            'image' => $name,
            'description' => $request->description,
        ];
        $company_project = CompanyProject::create($data);
        $company_project = CompanyProject::with('project_sub_images')->where('id', $company_project->id)->first();
        if ($company_project) {
            return response()->json(
                [
                    'message' => 'Added Successfully',
                    'status' => true,
                    'data' => $company_project
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'Failed to add user',
                    'status' => true,
                    'data' => []
                ],
                200
            );
        }
    }
    public function company_project_delete(Request $request)
    {

        $project = CompanyProject::where('id', request('project_id'))->first();
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        $success = $project->delete();
        return response()->json(
            [
                'message' => 'Project deleted successfully',
                'status' => true,
            ],
            200
        );
    }
    // Edit company project 

    public function edit_company_project(Request $request)
    {
        $company_project = CompanyProject::with('project_sub_images')->where('id', request('project_id'))->first();
        if ($company_project == null) {
            $data = [
                'message' => 'Company Project not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $data = request(['project_id']);
        $data = $this->company_project_details_update($data);
        // update the User
        $company_project->update($data);

        return response()->json(
            [
                'message' => 'Edited successfully',
                'status' => true,
                'data' => $company_project,
            ],
            200
        );
    }

    public function company_project_details_update($date)
    {
        # code...
        if (request('name') != null) {
            $date['name'] = request('name');
        }
        if (request('description') != null) {
            $date['description'] = request('description');
        }
        if (request('image') != null) {
            $date['image'] = $this->save_company_project_image(request('image'));
        }

        return $date;
    }

    // add company project multiple images
    public function add_company_project_sub_images(Request $request)
    {
        $company_project = CompanyProject::where('id', $request->project_id)->first();
        if ($company_project == null) {
            $data = [
                'message' => 'Company Project not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        // decode the base64 image
        $project_images = [];
        $base64Files = request('sub_images');
        foreach ($base64Files as $base64pic) {
            $fileData = base64_decode($base64pic);
            $name = 'company_project_sub_images/' . Str::random(15) . '.png';
            Storage::put('public/' . $name, $fileData);

            $profile_image = [
                'project_id' => $request->project_id,
                'picture' => $name,
            ];

            $profile_image = CompanyProjectImage::create($profile_image);

            array_push($project_images, $profile_image);
        }

        return response()->json(
            [
                'message' => 'Project sub pictures updated',
                'status' => true,
                'data' => [
                    'project_sub_images' => $project_images,
                ],
            ],
            200
        );
    }

    //  delete company project sub image
    public function delete_company_project_sub_images(Request $request)
    {

        $image_id = $request->image_id;
        $image_data = CompanyProjectImage::where('id', $image_id)->first();
        if ($image_data == null) {
            $data = [
                'message' => 'Image Data not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        $image_data->delete();
        return response()->json(
            [
                'message' => 'Project sub picture deleted',
                'status' => true,
                'data' => (object) [],
            ],
            200
        );
    }

    public function save_company_project_image($base64File)
    {
        # code...
        $fileData = base64_decode($base64File);

        $name = 'company_project_images/' . Str::random(15) . '.png';

        Storage::put('public/' . $name, $fileData);
        return $name;
    }


    public function company_personal_projects(ComapnyProfile $request)
    {
        $company_id = $request->company_id;
        $page_no = $request->page_no;
        $company = User::find($company_id);
        if ($company == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        // get paginated data  

        $perPage = 6;

        $offset = ($page_no - 1) * $perPage;
        $get_company_projects = CompanyProject::with('project_sub_images')->skip($offset)->where('company_id', $company_id)->take($perPage)->get();

        $totalPages = ceil(CompanyProject::where(['company_id' => $company_id])->count() / $perPage);
        if (count($get_company_projects) > 0) {
            return response()->json(
                [
                    'message' => 'Company Projects found succesfully',
                    'status' => true,
                    'data' => [
                        'page_data' => $get_company_projects,
                        'total_pages' => $totalPages
                    ]
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'No Data Found',
                    'status' => true,
                    'data' => [
                        'page_data' => [],
                        'total_pages' => 0
                    ]
                ],
                200
            );
        }
    }

    // Edit user profile 

    public function edit_profile(EditProfile $request)
    {

        $user = User::with('company_type.services')->find(request('user_id'));
        if ($user == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $data = request(['user_id']);
        $data = $this->generate_date_for_update($data);
        // update the User
        $user->update($data);
        $user['first_login'] = false;
        $user['distance'] = "";
        $user['totalProjects'] = 0;
        $user['saved'] = 0;
        $user['avgRating'] = 0;
        $user['totalRating'] = 0;

        return response()->json(
            [
                'message' => 'Edited successfully',
                'status' => true,
                'data' => $user,
            ],
            200
        );
    }

    public function generate_date_for_update($date)
    {
        # code...
        if (request('name') != null) {
            $date['name'] = request('name');
        }
        if (request('phone') != null) {
            $date['phone'] = request('phone');
        }
        if (request('company_tax') != null) {
            $date['company_tax'] = request('company_tax');
        }
        if (request('description') != null) {
            $date['description'] = request('description');
        }
        if (request('no_employee') != null) {
            $date['no_employee'] = request('no_employee');
        }
        if (request('lat') != null) {
            $date['lat'] = request('lat');
        }
        if (request('long') != null) {
            $date['long'] = request('long');
        }
        if (request('location') != null) {
            $date['location'] = request('location');
        }

        return $date;
    }
    // Add/Edit service
    public function service_against_company_type_add(EditService $request)
    {
        $user = User::find(request('company_id'));
        if ($user == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }


        $services = $user->services;
        $new_service = request('services');

        $check_if_already_present = array_intersect($services, $new_service);

        if (!empty($check_if_already_present)) {
            $data = [
                'message' => 'You have already added this service',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $updatedServices = array_merge($services, $new_service);
        $user->services = $updatedServices;
        $user->save();


        foreach ($new_service as $service) {
            $service_name = Service::where('id', $service)->pluck('name')->first();
            $service_data = [
                'user_company_type_id' => request('company_type_id'),
                'service_id' => $service,
                'name' => $service_name
            ];
            $servicesData = UserCompanyServices::create($service_data);
        }
        $data = [
            'message' => 'User Service added',
            'status' => true,
            'data' => (object) [],
        ];

        return response()->json($data, 200);
    }
    // Service Delete
    public function service_against_company_type_delete(EditService $request)
    {
        $user = User::find(request('company_id'));

        if ($user == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        $services = $user->services;
        $service_for_delete = request('service_id');
        $index_for_delete = array_search($service_for_delete, $services);

        // if no service in the database.
        if ($index_for_delete === false) {
            $data = [
                'message' => 'Service not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        unset($services[$index_for_delete]);
        $services = array_values($services);

        $user->services = $services;
        $user->save();

        $user_company_services = UserCompanyServices::where([
            'user_company_type_id' => request('company_type_id'),
            'service_id' => request('service_id'),
        ])->delete();

        $data = [
            'message' => 'User Services deleted',
            'status' => true,
            'data' => (object) [],
        ];

        return response()->json($data, 200);
    }

    // Add Edit Company Type
    public function company_type_add(EditService $request)
    {
        $user = User::find(request('company_id'));
        if ($user == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }


        $company_type = $user->company_type;
        $new_company_type = request('company_type_id');

        $check_if_already_present = in_array($new_company_type, $company_type);

        if (!empty($check_if_already_present)) {
            $data = [
                'message' => 'You have already added this company type',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        array_push($company_type, $new_company_type);
        $user->company_type = $company_type;
        $user->save();

        $company_type_name = CompanyType::where('id', $new_company_type)->pluck('name')->first();
        $typedata = [
            'company_id' => $user->id,
            'company_type_id' => $new_company_type,
            'name' => $company_type_name,
        ];
        $company_type = UserCompanyType::create($typedata);
        $data = [
            'message' => 'Company Type added',
            'status' => true,
            'data' => (object) [],
        ];

        return response()->json($data, 200);
    }

    // Company Type Delete 
    public function company_type_delete(EditService $request)
    {
        $user = User::find(request('company_id'));

        if ($user == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        $company_type = $user->company_type;
        $company_type_for_delete = request('company_type_id');
        $index_for_delete = array_search($company_type_for_delete, $company_type);

        // if no service in the database.
        if ($index_for_delete === false) {
            $data = [
                'message' => 'Company Type not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        unset($company_type[$index_for_delete]);
        $company_type = array_values($company_type);

        $user->company_type = $company_type;
        $user->save();

        $user_company_type = UserCompanyType::where([
            'company_type_id' => request('company_type_id'),
            'company_id' => request('company_id'),
        ])->first();
        $user_company_services = UserCompanyServices::where([
            'user_company_type_id' => $user_company_type->id,
        ])->pluck('service_id')->toArray();

        $user_services = $user->services;
        $user_services = array_diff($user_services, $user_company_services);

        $user->services = $user_services;
        $user->save();
        $user_company_type->delete();
        $data = [
            'message' => 'User Company type deleted',
            'status' => true,
            'data' => (object) [],
        ];

        return response()->json($data, 200);
    }

    // Socail signup edit screen api 
    public function socail_edit_profile(SocailEditProfile $request)
    {

        $id = request('user_id');
        $user = User::with('company_type.services')->where('id', $id)->first();
        if ($user == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        if (request('name') != null) {
            $user->name = request('name');
        }

        if (request('email') != null) {
            $check_email =  User::where('email', request('email'))->first();
            if ($check_email) {
                $data = [
                    'message' => 'This email is already connected to an account in our database',
                    'status' => false,
                    'data' => [],
                ];

                return response($data, 401);
            } else {
                $user->email = request('email');
            }
        }
        $company_type_data = [];
        $serviceData = [];
        $company_type = request('company_type');
        if ($company_type) {
            foreach ($company_type as $row) {
                $company_type_name = CompanyType::where('id', $row['id'])->pluck('name')->first();
                $typedata = [
                    'company_id' => $user->id,
                    'company_type_id' => $row['id'],
                    'name' => $company_type_name,
                ];
                $company_type = UserCompanyType::create($typedata);
                $company_type_data[] = $row['id'];
                $services = $row['services'];
                foreach ($services as $service) {
                    $service_name = Service::where('id', $service)->pluck('name')->first();
                    $service_data = [
                        'user_company_type_id' => $company_type->id,
                        'service_id' => $service,
                        'name' => $service_name
                    ];
                    $servicesData = UserCompanyServices::create($service_data);
                    $serviceData[] = $service;
                }
            }
        }
        $user->services = $serviceData;
        $user->company_type = $company_type_data;
        $user->phone = request('phone');
        $user->user_type = request('user_type');
        $user->company_tax = request('company_tax');
        $user->email_verified = 1;
        $user->no_employee = request('no_employee');
        $user->save();
        $user_data = User::with('company_type.services')->where('id', $user->id)->first();
        $data = [
            'message' => 'User updated successfully',
            'status' => true,
            'data' => $user_data,
            'user_token' => $user_data->createToken('Probau')->plainTextToken
        ];

        return response($data, 200);
    }

    // delete user account
    public function delete_account(Request $request)
    {

        $user = User::find(request('user_id'));
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $my_project = Project::where([
            'user_id' => request('user_id'),
        ])->pluck('id')->toArray();

        $ongoing_project_with_other_user = OngoingProject::whereIn('project_id', $my_project)->where('status', 1)->get();

        $my_ongoing =  OngoingProject::where(['company_id' => request('user_id'), 'status' => 1])->get();
        if (count($my_ongoing) > 0 || count($ongoing_project_with_other_user) > 0) {
            return response()->json(
                [
                    'message' => 'Please Complete your project before deleting your account',
                    'status' => false,
                ],
                200
            );
        }
        $success = $user->delete();
        return response()->json(
            [
                'message' => 'User deleted successfully',
                'status' => true,
            ],
            200
        );
    }

    // update range for notification range 

    public function update_range_for_notification(Request $request)
    {

        $user_id = $request->user_id;
        $user = User::find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }

        if ($request->range_for_user_project != 0) {
            $user->range_for_user_project = $request->range_for_user_project;
        }
        if ($request->range_for_company_projects != 0) {
            $user->range_for_company_projects = $request->range_for_company_projects;
        }
        if ($request->range_for_nearby_projects != 0) {
            $user->range_for_nearby_projects = $request->range_for_nearby_projects;
        }
        if ($request->range_for_recommended_companies != 0) {
            $user->range_for_recommended_companies = $request->range_for_recommended_companies;
        }
        if ($request->range_for_nearby_companies != 0) {
            $user->range_for_nearby_companies = $request->range_for_nearby_companies;
        }

        $user->save();

        $data = [
            'message' => 'Updated successfully',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    // Saved Projects
    public function saved_project(Request $request)
    {

        $user_id = $request->user_id;
        $user = User::find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $save_projects = SavedProject::where('user_id', $user_id)->get();
        foreach ($save_projects as $row) {
            $project = Project::with('company_types.services')->where('id', $row->project_id)->select('id', 'name', 'services', 'company_type', 'image', 'project_type')->first();
            $row->project_detail = $project;
        }
        if (count($save_projects) > 0) {
            return response()->json(
                [
                    'message' => 'Data Fetched Successfully',
                    'status' => true,
                    'data' => $save_projects
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'No Data found',
                    'status' => true,
                    'data' =>  []
                ],
                200
            );
        }
    }

    // Saved Companies
    public function saved_company(Request $request)
    {

        $user_id = $request->user_id;
        $user = User::find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $save_companies = SavedCompany::where('user_id', $user_id)->get();
        foreach ($save_companies as $row) {
            $company = User::where('id', $row->company_id)->select('id', 'name', 'description', 'profile_pic')->first();

            // total projects count
            // get those projects  which company has completed working with other private user/company
            $completed_Projects = $this->totalCompletedProjects($row->company_id);
            $company->totalProjects = count($completed_Projects);

            // total reviews count
            $reviews = Review::where('company_id', $row->company_id)->get();
            $averageRating = round($reviews->avg('rating'), 1);
            $totalRating = $reviews->count();
            $company->avgRating = $averageRating;
            $company->totalRating = $totalRating;
            $row->company_detail = $company;
        }
        if (count($save_companies) > 0) {
            return response()->json(
                [
                    'message' => 'Data Fetched Successfully',
                    'status' => true,
                    'data' => $save_companies
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'No Data found',
                    'status' => true,
                    'data' =>  []
                ],
                200
            );
        }
    }

    // get company by company id 
    public function company_by_company_id(CompanyGet $request)
    {

        $user_id = $request->user_id;
        $company_id = $request->company_id;
        $user = User::find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }
        $company = User::with('company_type.services')->find($company_id);
        if ($company == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }



        // total projects count
        // get those projects  which company has completed working with other private user/company
        $completed_Projects = $this->totalCompletedProjects($company_id);
        $company->totalProjects = count($completed_Projects);

        // total reviews count
        $reviews = Review::where('company_id', $company_id)->get();
        $averageRating = round($reviews->avg('rating'), 1);
        $totalRating = $reviews->count();
        $company->avgRating = $averageRating;
        $company->totalRating = $totalRating;

        // get saved details
        $saved = SavedCompany::where([
            'user_id' => $user_id,
            'company_id' => $company_id,
        ])->first();
        if ($saved) {
            $company->saved = 1;
        } else {
            $company->saved = 0;
        }
        return response()->json(
            [
                'message' => 'Company Details',
                'status' => true,
                'data' => $company
            ],
            200
        );
    }

    // ongoing projects
    public function ongoing_projects(Request $request)
    {

        $company_id = $request->company_id;
        $company = User::find($company_id);
        if ($company == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $projects = OngoingProject::where([
            'company_id' => $company_id,
            'status' => 1,
        ])->get();


        foreach ($projects as $row) {
            $project = Project::with('company_types.services')->where([
                'id' => $row->project_id,
            ])->select('id', 'name', 'image', 'services', 'company_type')->first();

            foreach ($project->company_types as $company) {
                $company->has_requests = false;

                foreach ($company->services as $service) {

                    $user_services = $company->services;
                    $check_match = array_search($service->service_id, $user_services);
                    if ($check_match !== false) {
                        $service->is_matched = true;
                    } else {
                        $service->is_matched = false;
                    }

                    $service->has_requested = ProjectRequest::where('project_id', $project->id)
                        ->where('service_id', $service->service_id)
                        ->exists();
                    $service->is_request_accepted = ProjectRequest::where('project_id', $project->id)
                        ->where('service_id', $service->service_id)
                        ->where('status', 1)
                        ->exists();
                }
            }
        }
        if (count($projects) > 0) {
            return response()->json(
                [
                    'message' => 'Data Fetched Successfully',
                    'status' => true,
                    'data' => $projects
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'No Data found',
                    'status' => true,
                    'data' =>  []
                ],
                200
            );
        }
    }

    // sent project requests

    public function my_requests(MyRequests $request)
    {
        $filter = $request->filter;
        $type = $request->type;
        $company_id = $request->company_id;
        $company = User::find($company_id);
        if ($company == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        $project_ids = ProjectRequest::where('company_id', $company_id)->pluck('project_id')->toArray();
        $company_projects = Project::whereIn('id', $project_ids)->where('project_type', 'company')->pluck('id')->toArray();
        $user_projects = Project::whereIn('id', $project_ids)->where('project_type', 'user')->pluck('id')->toArray();
        if ($type == '1') {
            $requests = ProjectRequest::whereIn('project_id', $user_projects)->where('company_id', $company_id)->get();
        } else {
            $requests = ProjectRequest::whereIn('project_id', $company_projects)->where('company_id', $company_id)->get();
        }

        foreach ($requests as $row) {

            $project = Project::with('company_types.services')->where([
                'id' => $row->project_id,
            ])->select('id', 'name', 'image', 'services', 'company_type')->first();

            foreach ($project->company_types as $companys) {
                $companys->has_requests = false;

                foreach ($companys->services as $service) {

                    $user_services = $company->services;
                    $check_match = array_search($service->service_id, $user_services);
                    if ($check_match !== false) {
                        $service->is_matched = true;
                    } else {
                        $service->is_matched = false;
                    }

                    $service->has_requested = ProjectRequest::where('project_id', $project->id)
                        ->where('service_id', $service->service_id)
                        ->exists();
                    $service->is_request_accepted = ProjectRequest::where('project_id', $project->id)
                        ->where('service_id', $service->service_id)
                        ->where('status', 1)
                        ->exists();
                }
            }
            $row->project_detail = $project;
        }

        if (count($requests) > 0) {
            return response()->json(
                [
                    'message' => 'Data Fetched Successfully',
                    'status' => true,
                    'data' => $requests
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'No Data found',
                    'status' => true,
                    'data' =>  []
                ],
                200
            );
        }
    }

    // Search History 
    public function search_history(RecentSearches $request)
    {
        $user_id = $request->user_id;
        $type = $request->type;
        $user = User::find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' =>  [],
            ];

            return response()->json($data, 200);
        }

        if ($type == '1') {
            $searches = RecentSearch::where([
                'user_id' => $user_id,
                'search_type' => 'project'
            ])->orderBy('id', 'DESC')->get();
            foreach ($searches as $row) {
                $project = Project::with('company_types.services')->where('id', $row->search_id)->select('id', 'name', 'image', 'services', 'company_type')->first();
                // save data 
                $saved = SavedProject::where('user_id', $user_id)->where('project_id', $row->search_id)->first();
                if ($saved) {
                    $project->saved = 1;
                } else {
                    $project->saved = 0;
                }
                $row->project_detail = $project;
            }
        } else {
            $searches = RecentSearch::where([
                'user_id' => $user_id,
                'search_type' => 'company'
            ])->orderBy('id', 'DESC')->get();
            foreach ($searches as $row) {
                $company = User::where('id', $row->search_id)->select('id', 'name', 'description', 'profile_pic')->first();

                // total projects count
                // get those projects  which company has completed working with other private user/company
                $completed_Projects = $this->totalCompletedProjects($row->search_id);
                $company->totalProjects = count($completed_Projects);

                // total reviews count
                $reviews = Review::where('company_id', $row->search_id)->get();
                $averageRating = round($reviews->avg('rating'), 1);
                $totalRating = $reviews->count();
                $company->avgRating = $averageRating;
                $company->totalRating = $totalRating;
                $row->company_detail = $company;

                // get saved details
                $saved = SavedCompany::where([
                    'user_id' => $user_id,
                    'company_id' => $row->search_id,
                ])->first();
                if ($saved) {
                    $company->saved = 1;
                } else {
                    $company->saved = 0;
                }
            }
        }

        if (count($searches) > 0) {
            $data = [
                'message' => 'searches data load successfully',
                'status' => true,
                'data' => $searches
            ];
            return response($data, 200);
        } else {
            $data = [
                'message' => 'No searches found',
                'status' => true,
                'data' => []
            ];
            return response($data, 200);
        }
    }

    // 

    public function totalCompletedProjects($company_id)
    {
        $completed_projects = OngoingProject::where([
            'company_id' => $company_id,
        ])->pluck('project_id')->toArray();

        return $completed_projects;
    }
}
