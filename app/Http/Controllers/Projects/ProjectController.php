<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\{User, ProjectCompanyType, ProjectCompanyService, ProjectServices, CompanyType, Service, Project, Review, ProjectRequest, OngoingProject, Notification, LatestProjectRelation};
use App\Http\Requests\{CreateProject, ProjectReq, EditProjectService, EditProjectCompanyType, AddReview, UpdateProjectStatus, RequestRespond, ProjectGet};
use App\Models\SavedProject;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Jobs\AutoNotificationForProject;

class ProjectController extends Controller
{

    public function create_project(CreateProject $request)
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

        $project_type = $user->user_type;
        $base64File = request('image');

        // store orignal image
        $fileData = base64_decode($base64File);

        $name = 'projects_image/' . Str::random(15) . '.png';

        Storage::put('public/' . $name, $fileData);

        $data = [
            'user_id' => $request->user_id,
            'name' => $request->name,
            'image' => $name,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'time' => $request->time,
            'lat' => $request->lat,
            'long' => $request->long,
            'location' => $request->location,
            'description' => $request->description ?? '',
            'company_type' => $request->company_type,
            'project_type' => $project_type,
            'status' => "1"

        ];
        $project = Project::create($data);

        $company_type_data = [];
        $serviceData = [];
        $company_type = $request->company_type;
        if ($company_type) {
            foreach ($company_type as $row) {
                $company_type_name = CompanyType::where('id', $row['id'])->pluck('name')->first();
                $typedata = [
                    'project_id' => $project->id,
                    'company_type_id' => $row['id'],
                    'name' => $company_type_name,
                ];
                $company_type = ProjectCompanyType::create($typedata);
                $company_type_data[] = $row['id'];
                $services = $row['services'];
                foreach ($services as $service) {
                    $service_name = Service::where('id', $service['id'])->pluck('name')->first();
                    $service_data = [
                        'project_company_type_id' => $company_type->id,
                        'service_id' => $service['id'],
                        'name' => $service_name,
                        'description' => $service['description'] ?? ""
                    ];
                    $servicesData = ProjectCompanyService::create($service_data);
                    $serviceData[] = $service['id'];
                }
            }
        }
        $project->services = $serviceData;
        $project->company_type = $company_type_data;
        $project->save();
        $project_data = Project::with('company_types.services')->where('id', $project->id)->first();

        foreach ($project_data->company_types as $company) {
            $company->has_requests = false;

            foreach ($company->services as $service) {
                $service->is_matched = false;
                $service->has_requested = false;
                $service->is_request_accepted = false;
            }
        }
        $project_data['request_status'] = ProjectRequest::where('project_id', $project->id)
            ->where('status', 1)
            ->exists();
        // dispatch a job to send notification to the companies 
        dispatch(new AutoNotificationForProject($project->id));

        return response()->json(
            [
                'message' => 'Project Created Successfully',
                'status' => true,
                'data' => $project_data
            ],
            200
        );
    }

    public function my_projects(ProjectReq $request)
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
        $status = $request->status;

        $project = Project::with('company_types.services')->where([
            'user_id' => $user_id,
            'status' => $status
        ])->get();
        foreach ($project as $row) {
            // start and end time
            $row['start_time'] = Carbon::parse($row->created_at)->format('M d, Y') ?? "";
            if ($row->status == 3) {
                $row['end_time'] = Carbon::parse($row->updated_at)->format('M d, Y') ?? "";
            } else {
                $row['end_time'] = "";
            }

            foreach ($row->company_types as $company) {
                $company->has_requests = ProjectRequest::where('project_id', $row->id)
                    ->where('status', 0)
                    ->exists();

                foreach ($company->services as $service) {
                    $service->is_matched = false;
                    $service->has_requested = false;
                    $service->is_request_accepted = false;
                }
            }


            $row['request_status'] = ProjectRequest::where('project_id', $row->id)
                ->where('status', 1)
                ->exists();
            $row['new_requests'] = ProjectRequest::where('project_id', $row->id)
                ->where('status', 0)
                ->count();
        }
        return response()->json(
            [
                'message' => 'Project Created Successfully',
                'status' => true,
                'data' => $project
            ],
            200
        );
    }

    // Edit user profile 

    public function my_project(Request $request)
    {

        $project = Project::with("company_type.services")->find(request('project_id'));
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $data = request(['project_id']);
        $data = $this->generate_date_for_update($data);
        // update the User
        $project->update($data);

        foreach ($project->company_types as $company) {
            $company->has_requests = ProjectRequest::where('project_id', $project->id)
                ->where('company_type_id', $company->company_type_id)
                ->where('status', 0)
                ->exists();

            foreach ($company->services as $service) {
                $service->is_matched = false;
                $service->has_requested = false;
                $service->is_request_accepted = false;
            }
        }

        $project->request_status = ProjectRequest::where('project_id', $project->id)
            ->where('status', 1)
            ->exists();

        return response()->json(
            [
                'message' => 'Edited successfully',
                'status' => true,
                'data' => $project,
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
        if (request('time') != null) {
            $date['time'] = request('time');
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
        if (request('email') != null) {
            $date['email'] = request('email');
        }
        if (request('phone_no') != null) {
            $date['phone_no'] = request('phone_no');
        }
        if (request('description') != null) {
            $date['description'] = request('description');
        }
        if (request('image') != null) {
            $date['image'] = $this->save_base64_image(request('image'));
        }

        return $date;
    }


    public function update_project_service_data($services, $project_id)
    {
        $data = ProjectServices::where('project_id', $project_id)->delete();
        foreach ($services as $row) {
            $data = [
                'project_id' => $project_id,
                'service_id' => $row['id'],
                'description' => $row['description'],
                'status' => 1
            ];
            ProjectServices::create($data);
        }
    }

    public function save_base64_image($base64File)
    {
        # code...
        $fileData = base64_decode($base64File);

        $name = 'projects_image/' . Str::random(15) . '.png';

        Storage::put('public/' . $name, $fileData);
        // update the user's profile_pic
        return $name;
    }

    // Add/Edit service
    public function service_against_company_type_add(EditProjectService $request)
    {
        $project = Project::find(request('project_id'));
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }


        $services = $project->services;
        $new_services = request('services');

        $new_services_ids = array_column($new_services, 'id');

        $check_if_already_present = array_intersect($services, $new_services_ids);

        if (!empty($check_if_already_present)) {
            $data = [
                'message' => 'You have already added this service',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $updatedServices = array_merge($services, $new_services_ids);
        $project->services = $updatedServices;
        $project->save();


        foreach ($new_services as $service) {
            $service_name = Service::where('id', $service)->pluck('name')->first();
            $service_data = [
                'project_company_type_id' => request('company_type_id'),
                'service_id' => $service['id'],
                'description' => $service['description'] ?? "",
                'name' => $service_name
            ];
            $servicesData = ProjectCompanyService::create($service_data);
        }
        $data = [
            'message' => 'Project Service added',
            'status' => true,
            'data' => (object) [],
        ];

        return response()->json($data, 200);
    }
    // Service Delete
    public function service_against_company_type_delete(EditProjectService $request)
    {
        $project = Project::find(request('project_id'));
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        $services = $project->services;
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

        $project->services = $services;
        $project->save();

        $user_company_services = ProjectCompanyService::where([
            'project_company_type_id' => request('company_type_id'),
            'service_id' => request('service_id'),
        ])->delete();

        $data = [
            'message' => 'Project Services deleted',
            'status' => true,
            'data' => (object) [],
        ];

        return response()->json($data, 200);
    }


    // Add Edit Company Type
    public function company_type_add(EditProjectCompanyType $request)
    {
        $project = Project::find(request('project_id'));
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }


        $company_type = $project->company_type;
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
        $project->company_type = $company_type;
        $project->save();

        $company_type_name = CompanyType::where('id', $new_company_type)->pluck('name')->first();
        $typedata = [
            'project_id' => $project->id,
            'company_type_id' => $new_company_type,
            'name' => $company_type_name,
        ];
        $company_type = ProjectCompanyType::create($typedata);
        $data = [
            'message' => 'Company Type added',
            'status' => true,
            'data' => (object) [],
        ];

        return response()->json($data, 200);
    }
    // Company Type Delete 
    public function company_type_delete(EditProjectCompanyType $request)
    {
        $project = Project::find(request('project_id'));
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        $company_type = $project->company_type;
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

        $project->company_type = $company_type;
        $project->save();

        $user_company_type = ProjectCompanyType::where([
            'company_type_id' => request('company_type_id'),
            'project_id' => request('project_id'),
        ])->first();
        $user_company_services = ProjectCompanyService::where([
            'project_company_type_id' => $user_company_type->id,
        ])->pluck('service_id')->toArray();

        $user_services = $project->services;
        $user_services = array_diff($user_services, $user_company_services);

        $project->services = $user_services;
        $project->save();
        $user_company_type->delete();
        $data = [
            'message' => 'Project Company type deleted',
            'status' => true,
            'data' => (object) [],
        ];

        return response()->json($data, 200);
    }

    // delete project
    public function delete_project(Request $request)
    {

        $project = Project::find(request('project_id'));
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }

        $ongoing =  OngoingProject::where(['project_id' => $project->id, 'status' => 1])->get();
        if (count($ongoing) > 0) {
            return response()->json(
                [
                    'message' => 'Please Complete your project before deleting it',
                    'status' => false,
                ],
                200
            );
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


    // project detail by project id

    public function project_by_project_id(ProjectGet $request)
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
        $project_id = $request->project_id;
        $project = Project::with('company_types.services')->find($project_id);
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }
        $user_type = $user->user_type;
        $project_type = $project->project_type;

        foreach ($project->company_types as $company) {
            $company->has_requests = ProjectRequest::where('project_id', $project->id)
                ->where('company_type_id', $company->company_type_id)
                ->where('status', 0)
                ->exists();

            foreach ($company->services as $service) {

                $user_services = $user->services;
                $check_match = array_search($service->service_id, $user_services);
                if ($check_match !== false) {
                    $service->is_matched = true;
                } else {
                    $service->is_matched = false;
                }

                $service->has_requested = ProjectRequest::where('project_id', $project->id)
                    ->where('service_id', $service->service_id)
                    ->where('company_id', $user_id)
                    ->where('status', 0)
                    ->exists();
                $service->is_request_accepted = ProjectRequest::where('project_id', $project->id)
                    ->where('service_id', $service->service_id)
                    ->where('company_id', $user_id)
                    ->where('status', 1)
                    ->exists();
            }
        }
        // uploaded by
        $pUserID = $project->user_id;
        $uploaded_by = User::with('company_type.services')->where('id', $pUserID)->select('id', 'name', 'email', 'profile_pic', 'company_type')->first();
        $project->uploaded_by = $uploaded_by;


        // start and end time
        $project->start_time = Carbon::parse($project->created_at)->format('M d, Y') ?? "";
        if ($project->status == 3) {
            $project->end_time = Carbon::parse($project->updated_at)->format('M d, Y') ?? "";
        } else {
            $project->end_time = "";
        }
        // get saved details
        $saved = SavedProject::where([
            'user_id' => $user_id,
            'project_id' => $project_id,
        ])->first();
        if ($saved) {
            $project->saved = 1;
        } else {
            $project->saved = 0;
        }

        // check if project has requests
        $project->has_requests = ProjectRequest::where('project_id', $project_id)
            ->where('status', 0)
            ->exists();

        // check if user has reviewed on this project 
        $project->is_reviewed = Review::where([
            'user_id' => $user_id,
            'project_id' => $project_id,
        ])->exists();

        $project->request_status = ProjectRequest::where('project_id', $project_id)
            ->where('status', 1)
            ->exists();

        return response()->json(
            [
                'message' => 'Project Details',
                'status' => true,
                'data' => $project
            ],
            200
        );
    }

    // add review 
    public function add_review(AddReview $request)
    {
        $user_id = $request->user_id;
        $project_id = $request->project_id;
        $company_id = $request->company_id;
        $service_id = $request->service_id;
        $rating = $request->rating;
        $message = $request->message;
        $project = Project::find($project_id);
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }

        // check if already reviewd on this service
        $check = Review::where([
            'user_id' => $user_id,
            'project_id' => $project_id,
            'service_id' => $service_id
        ])->first();
        if ($check) {
            $data = [
                'message' => 'You have already reviewed this service',
                'status' => false,
            ];

            return response()->json($data, 200);
        }


        // Add Rating
        $data = [
            "user_id" => $user_id,
            "company_id" => $company_id,
            "rating" => $rating,
            "message" => $message,
            "project_id" => $project_id,
            "service_id" => $service_id
        ];

        $add_rating = Review::create($data);
        $company = User::find($company_id);
        $user = User::find($user_id);
        $user_name = $user->name;
        $project_name = $project->name;
        // send notiofication to the company user 
        $device_id = $company->device_id;
        $notifTitle = "New Review Added";
        $notiBody = $user_name . ' ' . ' added a review to your profile on,' . ' ' . $project_name;
        $this->send_notification($device_id, $notifTitle, $notiBody);

        // save notification in database 
        $notiData = [
            'user_id' => $company_id,
            'title' => $notifTitle,
            'body' => $notiBody,
            'data_id' => $company_id,
            'type' => 'review_added',
            'status' => 0
        ];

        $notification = Notification::create($notiData);

        return response()->json(
            [
                'message' => 'Review added successfully',
                'status' => true,
            ],
            200
        );
    }

    // get all project request
    public function request_list(Request $request)
    {

        $project_id = $request->project_id;
        $project = Project::find($project_id);
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
                'data' => (object) []
            ];

            return response()->json($data, 200);
        }

        $company_type_id = $request->company_type_id;
        $requests = ProjectRequest::where([
            'project_id' => $project_id,
            'company_type_id' => $company_type_id
        ])
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($requests as $row) {
            $company = User::with('company_type.services')->where('id', $row->company_id)->select('id', 'name', 'profile_pic', 'company_type', 'services', 'description')->first();
            // total reviews count
            $reviews = Review::where('company_id', $row->company_id)->get();
            $averageRating = round($reviews->avg('rating'), 1);
            $totalRating = $reviews->count();

            // total projects count
            // get those projects  which company has completed working with other private user/company
            $completed_Projects = $this->totalCompletedProjects($row->company_id);
            $company->totalProjects = count($completed_Projects);

            $project = Project::where('id', $row->project_id)->first();
            $user_id = $project->user_id;

            $company->is_reviewed = Review::where([
                'user_id' => $user_id,
                'project_id' => $row->project_id,
                'service_id' => $row->service_id
            ])->exists();


            $company->avgRating = $averageRating;
            $company->totalRating = $totalRating;
            $row->company_details = $company;
        }
        if (count($requests) > 0) {
            $data = [
                'message' => 'Requets on this project',
                'status' => true,
                'data' => $requests,
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'No New Requests',
                'status' => false,
                'data' =>  []
            ];

            return response()->json($data, 200);
        }
    }

    // update Project status

    public function update_project_status(UpdateProjectStatus $request)
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
        $project_id = $request->project_id;
        $status = $request->status;

        $project = Project::with('company_types.services')->find($project_id);
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }
        $project->status = $status;
        $project->save();
        // here i have to change the status of requests table ongoing project table also 
        if ($status == '1') {
            $message =  "project status moved to open";
        } else {

            // update ongoing project status 
            $ongoing =  OngoingProject::where(['project_id' => $project->id])->update(['status' => 3]);
            $message =  "project status moved to Completed";
        }
        foreach ($project->company_types as $company) {
            $company->has_requests = false;

            foreach ($company->services as $service) {

                $user_services = $user->services;
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

        // uploaded by
        $pUserID = $project->user_id;
        $uploaded_by = User::where('id', $pUserID)->select('id', 'name', 'email', 'profile_pic')->first();
        $project->uploaded_by = $uploaded_by;

        // start and end time
        $project->start_time = Carbon::parse($project->created_at)->format('M d, Y') ?? "";
        if ($project->status == 3) {
            $project->end_time = Carbon::parse($project->updated_at)->format('M d, Y') ?? "";
        } else {
            $project->end_time = "";
        }

        // get saved details
        $saved = SavedProject::where([
            'user_id' => $user_id,
            'project_id' => $project_id,
        ])->first();
        if ($saved) {
            $project->saved = 1;
        } else {
            $project->saved = 0;
        }

        // check if project has requests

        $project->has_requests = ProjectRequest::where('project_id', $project_id)
            ->where('status', 0)
            ->exists();

        $data = [
            'message' => $message,
            'status' => true,
            'data' => $project
        ];

        return response()->json($data, 200);
    }

    // project request respond
    public function request_respond(RequestRespond $request)
    {

        $project_id = $request->project_id;
        $request_id = $request->request_id;
        $status = $request->status;

        $project = Project::find($project_id);
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }
        $request = ProjectRequest::where('id', $request_id)->first();
        if ($request == null) {
            $data = [
                'message' => 'Request data not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }
        if ($status == 1) {
            $check_if_already_accepeted = $this->check_if_already_accepeted($request_id, $project_id);
            if ($check_if_already_accepeted) {
                $data = [
                    'message' => 'Already accepeted',
                    'status' => true,
                ];

                return response()->json($data, 200);
            }
            return $this->accept_request($request_id, $project_id);
        }
        if ($status == '2') {
            $check_if_already_rejected = $this->check_if_already_rejected($request_id, $project_id);
            if ($check_if_already_rejected) {
                $data = [
                    'message' => 'Already rejected',
                    'status' => true,
                ];

                return response()->json($data, 200);
            }
            return $this->reject_request($request_id, $project_id);
        }
    }

    // undo request 
    public function undo_request(Request $request)
    {

        $request_id = $request->request_id;

        $request = ProjectRequest::where('id', $request_id)->first();
        if ($request == null) {
            $data = [
                'message' => 'Request data not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }

        $company_id = $request->company_id;
        $project_id = $request->project_id;



        // delete all the requests in all states of the company with the project 

        $requests = ProjectRequest::where([
            'company_id' => $company_id,
            'project_id' => $project_id,
        ])->delete();

        // delete all the ongoing project services of the company with the project 

        $ongoing_projects =  OngoingProject::where([
            'company_id' => $company_id,
            'project_id' => $project_id,
        ])->delete();


        $data = [
            'message' => 'undo successfully',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function check_if_already_accepeted($request_id, $project_id)
    {

        $data = ProjectRequest::where('id', $request_id)->first();
        if ($data->status == '1') {
            return true;
        } else {
            return false;
        }
    }

    public function check_if_already_rejected($request_id, $project_id)
    {

        $data = ProjectRequest::where('id', $request_id)->first();

        if ($data->status == '2') {
            return true;
        } else {
            return false;
        }
    }

    public function accept_request($request_id, $project_id)
    {
        $data = ProjectRequest::where('id', $request_id)->first();
        $data->status = 1;
        $data->save();

        // make an entry to the ongoing project table 
        $create = [
            "project_id" => $project_id,
            "company_id" => $data->company_id,
            "service_id" => $data->service_id,
        ];

        $ongoing =  OngoingProject::create($create);

        $project = Project::find($project_id);
        $project_name = $project->name;
        $user_id = $project->user_id;
        $user = User::find($user_id);
        $user_name = $user->name;
        $service_id = $data->service_id;
        $service = Service::find($service_id);
        $service_name = $service->name;
        $company_id = $data->company_id;
        $company = User::find($company_id);
        // send notiofication to the company user 
        $device_id = $company->device_id;
        $notifTitle = "Project Request Accepted";
        $notiBody = $user_name . ' ' . ' accept your request on,' . ' ' . $project_name . ' ' . 'for,' . ' ' . $service_name;
        $this->send_notification($device_id, $notifTitle, $notiBody);

        // save notification in database 
        $notiData = [
            'user_id' => $company_id,
            'title' => $notifTitle,
            'body' => $notiBody,
            'data_id' => $project_id,
            'type' => 'request_accepted',
            'status' => 0
        ];

        $notification = Notification::create($notiData);

        // create/update latest project relationship of project owner(user_id/company_id) & service provider(company_id) 
        $this->project_relationship($user_id, $company_id, $project_id);

        $data = [
            'message' => 'Request Accepted',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function project_relationship($user_id, $company_id, $project_id)
    {
        // check if relationship exists then update the project id 

        $check = LatestProjectRelation::where([
            'project_owner' => $user_id,
            'service_provider' => $company_id,
        ])->first();
        if ($check) {
            $check->project_id = $project_id;
            $check->save();
            return true;
        }

        $projectRelation = [
            'project_owner' => $user_id,
            'service_provider' => $company_id,
            'project_id' => $project_id
        ];

        $cretae = LatestProjectRelation::create($projectRelation);
        return true;
    }


    public function reject_request($request_id, $project_id)
    {

        $data = ProjectRequest::where('id', $request_id)->first();
        $data->status = 2;
        $data->save();

        $project = Project::find($project_id);
        $project_name = $project->name;
        $user_id = $project->user_id;
        $user = User::find($user_id);
        $user_name = $user->name;
        $service_id = $data->service_id;
        $service = Service::find($service_id);
        $service_name = $service->name;
        $company_id = $data->company_id;
        $company = User::find($company_id);
        // send notiofication to the company user 
        $device_id = $company->device_id;
        $notifTitle = "Project Request Rejected";
        $notiBody = $user_name . ' ' . ' reject your request on,' . ' ' . $project_name . ' ' . 'for,' . ' ' . $service_name;
        $this->send_notification($device_id, $notifTitle, $notiBody);

        // save notification in database 
        $notiData = [
            'user_id' => $company_id,
            'title' => $notifTitle,
            'body' => $notiBody,
            'data_id' => $project_id,
            'type' => 'request_rejected',
            'status' => 0
        ];

        $notification = Notification::create($notiData);


        $data = [
            'message' => 'Request Declined',
            'status' => true,
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

    // send notification 
    public function send_notification($device_id, $notifTitle, $notiBody)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        // server key
        $serverKey =
            'AAAA_SK79PE:APA91bGbG4LCr_UvODx_zluYyFFpCzsCT8gHATUgrcnF1XOpicm-My5dBJfcvDdQq715atwH7hwvf3oOB7SSAt7VFVnf73pUSySZhGE0olECfc4XRDbvzY-KV6BjtZh2x0nh0RE2IQaN';

        $headers = [
            'Content-Type:application/json',
            'Authorization:key=' . $serverKey,
        ];

        // notification content
        $notification = [
            'title' => $notifTitle,
            'body' => $notiBody,
        ];
        // optional
        $dataPayLoad = [
            'to' => '/topics/test',
            'date' => '2019-01-01',
            'other_data' => 'Request Notification',
            'message_Type' => 'request',
            // 'notification' => $notification,
        ];

        // create Api body
        $notifbody = [
            'notification' => $notification,
            'data' => $dataPayLoad,
            'time_to_live' => 86400,
            'to' => $device_id,
            // 'registration_ids' => $arr,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notifbody));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);
    }

    public function latest_project(Request $request)
    {
        $user_1 = $request->user_1;
        $user_2 = $request->user_2;

        $relation = LatestProjectRelation::where([
            ['project_owner', '=', $user_1],
            ['service_provider', '=', $user_2],
        ])->orWhere([
            ['project_owner', '=', $user_2],
            ['service_provider', '=', $user_1],
        ])->first();

        if ($relation) {
            $project_id = $relation->project_id;

            $data = [
                'message' => 'latest project found',
                'status' => true,
                'project_id' => $project_id,
            ];
        } else {
            $data = [
                'message' => 'no latest project found',
                'status' => false,
                'project_id' => 0,
            ];
        }

        return response()->json($data, 200);
    }

    public function service_status(Request $request)
    {
        $service_id = $request->service_id;
        $project_id = $request->project_id;
        $project_company_type_id = $request->company_type_id;
        $status = $request->status;

        if ($status == 0) {

            $service_data = ProjectCompanyService::where([
                'service_id' => $service_id,
                'project_company_type_id' => $project_company_type_id
            ])->first();
            $service_data->status = 0;
            $service_data->save();

            $project  = Project::find($project_id);
            $services = $project->services;
            $service_for_delete = $service_id;
            $index_for_delete = array_search($service_for_delete, $services);

            // if no service in the database.
            if ($index_for_delete === false) {
                $data = [
                    'message' => 'Service not found',
                    'status' => false,
                ];

                return response()->json($data, 200);
            }

            unset($services[$index_for_delete]);
            $services = array_values($services);

            $project->services = $services;
            $project->save();
        } else {

            $service_data = ProjectCompanyService::where([
                'service_id' => $service_id,
                'project_company_type_id' => $project_company_type_id
            ])->first();
            $service_data->status = 1;
            $service_data->save();

            $project  = Project::find($project_id);
            $services = $project->services;

            $new_service = $service_id;
            $check_if_already_present = in_array($new_service, $services);
            if ($check_if_already_present == true) {
                $data = [
                    'message' => 'You have already added this service',
                    'status' => false,
                ];

                return response()->json($data, 200);
            }
            array_push($services, $new_service);
            $project->services = $services;
            $project->save();
        }

        $data = [
            'message' => 'Service status updated',
            'status' => true,
        ];

        return response()->json($data, 200);
    }
}
