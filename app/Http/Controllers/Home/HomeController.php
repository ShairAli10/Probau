<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\{User, CompanyType, Service, Project, SavedProject, ProjectRequest, Notification, SavedCompany, ProjectServices};
use App\Http\Requests\{SaveProject, Home, SaveCompany, SendProjectRequest};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    // company side Home
    public function company_home(Home $request)
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
        $userServices = $user->services;
        $lat = $user->lat;
        $longi = $user->long;

        if ($lat == "" || $longi == "") {
            $data = [
                'message' => 'Please turn on your location',
                'status' => false,
                'data' =>  [],
            ];

            return response()->json($data, 200);
        }

        if ($state == 1) {
            $project_status = 'user';  
            return $this->user_projects($user_id, $page_no, $userServices, $project_status, $lat, $longi, $user);
        } elseif ($state == 2) {
            $project_status = 'company';
            return $this->user_projects($user_id, $page_no, $userServices,  $project_status, $lat, $longi, $user);
        } elseif ($state == 3) {
            return $this->saved_projects($user_id, $page_no);
        } else {
            return $this->nearby_projects($user_id, $page_no, $userServices, $lat, $longi, $user);
        }
    }

    // Save Unsave Projects
    public function save_project(SaveProject $request)
    {

        $user_id = $request->user_id;
        $project_id = $request->project_id;
        $user = User::find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }
        $project = Project::find($project_id);
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }

        //  check if already saved project then unsave the prtoject


        $check = $this->project_already_saved($user_id, $project_id);
        if ($check) {
            $data = [
                'message' => 'Unsaved Successfully',
                'status' => false,
            ];

            return response()->json($data, 200);
        }

        // save the project 

        $data = [
            'user_id' => $user_id,
            'project_id' => $project_id
        ];
        $save_project = SavedProject::create($data);
        return response()->json(
            [
                'message' => 'Saved Successfully',
                'status' => true,
            ],
            200
        );
    }

    // Save Unsave Company
    public function save_company(SaveCompany $request)
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
        $company = User::find($company_id);
        if ($company == null) {
            $data = [
                'message' => 'company not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }

        //  check if already saved company then unsave the company

        $check = $this->company_already_saved($user_id, $company_id);
        if ($check) {
            $data = [
                'message' => 'Unsaved Successfully',
                'status' => false,
            ];

            return response()->json($data, 200);
        }

        // save the company 

        $data = [
            'user_id' => $user_id,
            'company_id' => $company_id
        ];
        $save_company = SavedCompany::create($data);
        return response()->json(
            [
                'message' => 'Saved Successfully',
                'status' => true,
            ],
            200
        );
    }

    // Send Project Request

    public function project_request(SendProjectRequest $request)
    {

        $company_id = $request->company_id;
        $project_id = $request->project_id;
        $company_type = $request->company_type;

        $user = User::find($company_id);
        if ($user == null) {
            $data = [
                'message' => 'Company not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }
        $project = Project::find($project_id);
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }

        //  check if already send request
        $check = $this->request_already_sent($company_id, $project_id, $company_type);
        if ($check) {
            $data = [
                'message' => 'You have already sent request on one of the selected services.',
                'status' => false,
            ];

            return response()->json($data, 200);
        }

        // save the project 

        return $this->send_project_request($company_id, $project_id, $company_type);
    }













    // check if already send request to the project
    public function request_already_sent($company_id, $project_id, $company_type)
    {
        foreach ($company_type as $company) {

            $services = $company['services'];
            foreach ($services as $service) {
                $check = ProjectRequest::where([
                    'company_id' => $company_id,
                    'project_id' => $project_id,
                    'company_type_id' => $company['id'],
                    'service_id' => $service
                ])->where('status', '!=', 2)->first();
                if ($check) {
                    return true;
                } else {
                    continue;
                }
            }
        }
    }

    // send request to the project
    public function send_project_request($company_id, $project_id, $company_type,)
    {

        foreach ($company_type as $company) {

            $services = $company['services'];
            foreach ($services as $service) {
                $data = [
                    'company_id' => $company_id,
                    'project_id' => $project_id,
                    'company_type_id' => $company['id'],
                    'service_id' => $service,
                    'status' => 0
                ];
                $send_request = ProjectRequest::create($data);

                // send the notification to the user and save notification data in the database 
                $company = User::find($company_id);
                $project = Project::find($project_id);
                $service = Service::find($service);
                $service_name = $service->name;
                $id = $project->user_id;
                $user = User::find($id);
                $device_id = $user->device_id;
                $company_name = $company->name;
                $project_name = $project->name;
                $notifTitle = "ProBau";
                $notiBody = $company_name . ' ' . 'has requested to work on your project,' . ' ' . $project_name . ', for service,' . '' . $service_name;
                $this->send_notification($device_id, $notifTitle, $notiBody);

                // save notification in database 

                $notiData = [
                    'user_id' => $id,
                    'title' => 'Project request',
                    'body' => $notiBody,
                    'status' => 0,
                    'data_id' => $project_id,
                    'type' => 'project_request'
                ];

                $notification = Notification::create($notiData);
            }
        }


        return response()->json(
            [
                'message' => 'Request Send Successfully',
                'status' => true,
            ],
            200
        );
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

    //  check if user has already saved the project then unsave the project
    public function project_already_saved($user_id, $project_id)
    {
        $check = SavedProject::where([
            'user_id' => $user_id,
            'project_id' => $project_id
        ])->first();
        if ($check) {
            $check->delete();
            return true;
        }
    }

    //  check if user has already saved the project then unsave the project
    public function company_already_saved($user_id, $company_id)
    {
        $check = SavedCompany::where([
            'user_id' => $user_id,
            'company_id' => $company_id
        ])->first();
        if ($check) {
            $check->delete();
            return true;
        }
    }

    // company user home data of private users / company users
    public function user_projects($user_id, $page_no, $userServices, $project_status, $lat, $longi, $user)
    {
        $perPage = 10;
        if($project_status == "user"){
            $radius = $user->range_for_user_project; // in kilometers
        }else{
            $radius = $user->range_for_company_projects; // in kilometers
        }
        $projects = Project::with('company_types.services')->select('projects.id', 'projects.user_id', 'projects.name', 'projects.image', 'projects.time', 'projects.lat', 'projects.long', 'projects.location', 'projects.description', 'projects.services', 'projects.company_type', 'projects.status', 'projects.project_type', 'projects.deleted_at', 'projects.created_at', 'projects.updated_at')
            ->where('user_id', '!=', $user_id)
            ->where('project_type', $project_status)
            ->where('status', 1)
            ->where(function ($query) use ($userServices) {
                foreach ($userServices as $userService) {
                    $query->orWhere(function ($subquery) use ($userService) {
                        $subquery->whereJsonContains('services', $userService);
                    });
                }
            })
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
        foreach ($projects as $row) {
            $id = $row['id'];
            $saved = SavedProject::where('user_id', $user_id)->where('project_id', $id)->first();
            if ($saved) {
                $row->saved = 1;
            } else {
                $row->saved = 0;
            }

            foreach ($row->company_types as $company) {
                $company->has_requests = false;

                foreach ($company->services as $service) {

                    $user_services = $user->services;
                    $check_match = array_search($service->service_id, $user_services);
                    if ($check_match !== false) {
                        $service->is_matched = true;
                    } else {
                        $service->is_matched = false;
                    }

                    $service->has_requested = ProjectRequest::where('project_id', $id)
                        ->where('service_id', $service->service_id)
                        ->exists();
                    $service->is_request_accepted = ProjectRequest::where('project_id', $id)
                        ->where('service_id', $service->service_id)
                        ->where('status', 1)
                        ->exists();
                }
            }

            $row->request_status = ProjectRequest::where('project_id', $row->id)
                ->where('status', 1)
                ->exists();
        }


        $totalProjects = Project::select('projects.id', 'projects.user_id', 'projects.name', 'projects.image', 'projects.time', 'projects.lat', 'projects.long', 'projects.location', 'projects.description', 'projects.services', 'projects.company_type', 'projects.status', 'projects.project_type', 'projects.deleted_at', 'projects.created_at', 'projects.updated_at')
            ->where('user_id', '!=', $user_id)
            ->where('status', 1)
            ->where('project_type', $project_status)
            ->where(function ($query) use ($userServices) {
                foreach ($userServices as $userService) {
                    $query->orWhere(function ($subquery) use ($userService) {
                        $subquery->whereJsonContains('services', $userService);
                    });
                }
            })
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


        if ($totalProjects > 0) {
            return $this->return_projects_found($projects, ceil($totalProjects / $perPage));
        } else {
            return $this->return_not_projects_found();
        }
    }

    // company user home data of saved projects
    public function saved_projects($user_id, $page_no)
    {
        $perPage = 10;
        $projects = SavedProject::where('user_id', $user_id)->skip(($page_no - 1) * $perPage)
            ->take($perPage)->get();
        $projectCollection = collect();
        foreach ($projects as $row) {
            $project = Project::with('company_types.services')->where('id', $row->project_id)->first();
            // matched service
            $user = User::find($user_id);
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

                    $service->has_requested = ProjectRequest::where('project_id', $row->id)
                        ->where('service_id', $service->service_id)
                        ->exists();
                    $service->is_request_accepted = ProjectRequest::where('project_id', $row->id)
                        ->where('service_id', $service->service_id)
                        ->where('status', 1)
                        ->exists();
                }
            }
            $project->saved = 1;
            $project->distance = "0";
            $projectCollection->push($project);

            $project->request_status = ProjectRequest::where('project_id', $row->id)
                ->where('status', 1)
                ->exists();
        }
        $totalProjects = SavedProject::where('user_id', $user_id)
            ->count();
        if (count($projects) > 0) {
            return $this->return_projects_found($projectCollection, ceil($totalProjects / $perPage));
        } else {
            return $this->return_not_projects_found();
        }
    }

    // company user home data of nearby projects
    public function nearby_projects($user_id, $page_no, $userServices, $lat, $longi, $user)
    {
        $perPage = 10;
        $radius = $user->range_for_nearby_projects; // in kilometers
        $projects = Project::with('company_types.services')->select('projects.id', 'projects.user_id', 'projects.name', 'projects.image', 'projects.time', 'projects.lat', 'projects.long', 'projects.location', 'projects.description', 'projects.services', 'projects.company_type', 'projects.status', 'projects.project_type', 'projects.deleted_at', 'projects.created_at', 'projects.updated_at')
            ->where('user_id', '!=', $user_id)
            ->where('status', 1)
            ->where(function ($query) use ($userServices) {
                foreach ($userServices as $userService) {
                    $query->orWhere(function ($subquery) use ($userService) {
                        $subquery->whereJsonContains('services', $userService);
                    });
                }
            })
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
        foreach ($projects as $row) {
            $id = $row['id'];
            $saved = SavedProject::where('user_id', $user_id)->where('project_id', $id)->first();
            if ($saved) {
                $row->saved = 1;
            } else {
                $row->saved = 0;
            }

            foreach ($row->company_types as $company) {
                $company->has_requests = false;

                foreach ($company->services as $service) {

                    $user_services = $user->services;
                    $check_match = array_search($service->service_id, $user_services);
                    if ($check_match !== false) {
                        $service->is_matched = true;
                    } else {
                        $service->is_matched = false;
                    }

                    $service->has_requested = ProjectRequest::where('project_id', $id)
                        ->where('service_id', $service->id)
                        ->exists();
                    $service->is_request_accepted = ProjectRequest::where('project_id', $id)
                        ->where('service_id', $service->id)
                        ->where('status', 1)
                        ->exists();
                }
            }

            $row->request_status = ProjectRequest::where('project_id', $row->id)
                ->where('status', 1)
                ->exists();
        }


        $totalProjects = Project::select('projects.id', 'projects.user_id', 'projects.name', 'projects.image', 'projects.time', 'projects.lat', 'projects.long', 'projects.location', 'projects.description', 'projects.services', 'projects.company_type', 'projects.status', 'projects.project_type', 'projects.deleted_at', 'projects.created_at', 'projects.updated_at')
            ->where('user_id', '!=', $user_id)
            ->where('status', 1)
            ->where(function ($query) use ($userServices) {
                foreach ($userServices as $userService) {
                    $query->orWhere(function ($subquery) use ($userService) {
                        $subquery->whereJsonContains('services', $userService);
                    });
                }
            })
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

        if ($totalProjects > 0) {
            return $this->return_projects_found($projects, ceil($totalProjects / $perPage));
        } else {
            return $this->return_not_projects_found();
        }
    }
    public function return_projects_found($projects, $totalPages)
    {
        $data = [
            'message' => 'Projects Found',
            'status' => true,
            'data' => $projects,
            'total_pages' => $totalPages
        ];

        return response()->json($data, 200);
    }

    public function return_not_projects_found()
    {
        $data = [
            'message' => 'Projects not Found',
            'status' => true,
            'data' => [],
            'total_pages' => 0
        ];

        return response()->json($data, 200);
    }
}
