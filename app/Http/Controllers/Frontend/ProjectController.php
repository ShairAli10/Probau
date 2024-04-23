<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\{User, ProjectServices, Project, CompanyType, Service, Review, OngoingProject, ProjectPayment, Subscription, SubscriptionPlan, PlanCharge};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public  function subscription_payment()
    {
        $data = Subscription::where('status', 1)->get();
        return view('frontend.SubscriptionPayment', compact('data'));
    }
    public function subscription_payments(Request $request)
    {
        $user = Subscription::where('status', 1)->paginate(10);
        foreach ($user as $row) {
            $company_detail = User::where('id', $row->user_id)->first();
            $row->company = $company_detail ?? (object)[];
            $plan_detail = SubscriptionPlan::find($row->plan_id);
            $row->plan_detail = $plan_detail;
            $charges_detail = PlanCharge::where('id', $row->charges_id)->first();
            $row->charges_detail = $charges_detail;
            $row->registration_date = $row->created_at->format('M d, Y');
        }
        return response()->json(['users' => $user]);
    }

    public  function project_payment()
    {
        $data = ProjectPayment::with('projects', 'user')->get();
        return view('frontend.ProjectPayments', compact('data'));
    }
    public function project_payments(Request $request)
    {

        $user = ProjectPayment::with('projects', 'user')->paginate(10);
        foreach ($user as $row) {
            $row->registration_date = $row->created_at->format('M d, Y');
        }
        return response()->json(['users' => $user]);
    }

    public  function company_projects()
    {

        $projects = Project::where('project_type', 'company')->get();
        return view('frontend.CompanyProjects', compact('projects'));
    }

    public function get_company_projects(Request $request)
    {
        $searchTerm = $request->input('search');
        $userCount = Project::where('project_type', 'company')->count();
        $query = Project::with('company_types.services')->where('project_type', 'company');

        if ($searchTerm) {
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }
        $sortingOption = $request->input('sorting'); // Get the sorting option from the request

        if ($sortingOption === 'open') {
            $query->where('status', 1);
        } elseif ($sortingOption === 'inprogress') {
            $query->where('status', 2);
        } elseif ($sortingOption === 'completed') {
            $query->where('status', 3);
        } else {
            $query->where('status', '!=',  0);
        }
        $user = $query->paginate(10);
        foreach ($user as $row) {
            $row->start_time = Carbon::parse($row->created_at)->format('M d, Y') ?? "";
            if ($row->status == 3) {
                $row->end_time = Carbon::parse($row->updated_at)->format('M d, Y') ?? "";
            } else {
                $row->end_time = "";
            }
            $row->uploaded_at  = $row->created_at->format('M d, Y');
        }

        return response()->json(['userCount' => $userCount, 'users' => $user]);
    }

    public  function user_projects()
    {

        $projects = Project::where('project_type', 'user')->get();
        return view('frontend.UserProjects', compact('projects'));
    }

    public function get_user_projects(Request $request)
    {
        $searchTerm = $request->input('search');
        $userCount = Project::where('project_type', 'user')->count();
        $query = Project::with('company_types.services')->where('project_type', 'user');

        if ($searchTerm) {
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }
        $sortingOption = $request->input('sorting'); // Get the sorting option from the request

        if ($sortingOption === 'open') {
            $query->where('status', 1);
        } elseif ($sortingOption === 'inprogress') {
            $query->where('status', 2);
        } elseif ($sortingOption === 'completed') {
            $query->where('status', 3);
        } else {
            $query->where('status', '!=',  0);
        }
        $user = $query->paginate(10);
        foreach ($user as $row) {
            $row->start_time = Carbon::parse($row->created_at)->format('M d, Y') ?? "";
            if ($row->status == 3) {
                $row->end_time = Carbon::parse($row->updated_at)->format('M d, Y') ?? "";
            } else {
                $row->end_time = "";
            }
            $row->uploaded_at  = $row->created_at->format('M d, Y');
        }

        return response()->json(['userCount' => $userCount, 'users' => $user]);
    }

    public function user_project_detail(Request $request, $id)
    {
        $project_id = $id;
        $project = Project::with('company_types.services')->find($project_id);

        $user_id = $project->user_id;
        $data = User::where('id', $user_id)->first();
        $project['uploaded_by'] = $data;
        // dd($project);

        // start and end time
        $project->start_time = Carbon::parse($project->created_at)->format('M d, Y') ?? "";
        if ($project->status == 3) {
            $project->end_time = Carbon::parse($project->updated_at)->format('M d, Y') ?? "";
        } else {
            $project->end_time = "";
        }

        return view('frontend.UserProjectDetail', compact('project'));
    }


    public function company_project_detail(Request $request, $id)
    {
        $project_id = $id;
        $project = Project::with('company_types.services')->find($project_id);

        
        $user_id = $project->user_id;
        $data = User::where('id', $user_id)->first();
        $project['uploaded_by'] = $data;
        $company_type_user = CompanyType::where('id', $data->company_type)->select('id', 'name')->first();
        $data->company_type = $company_type_user->name ?? "";
        $services_user = $data->services;
        $serviceData_user = [];
        foreach ($services_user as $row) {
            $service = Service::where('id', $row)->select('id', 'name')->first();
            $serviceData_user[] = $service;
        }
        $data->services = $serviceData_user;
        $reviews = Review::where('company_id', $user_id)->get();
        $averageRating = round($reviews->avg('rating'), 1);
        $data->rating = $averageRating;
        // start and end time
        // start and end time
        $project->start_time = Carbon::parse($project->created_at)->format('M d, Y') ?? "";
        if ($project->status == 3) {
            $project->end_time = Carbon::parse($project->updated_at)->format('M d, Y') ?? "";
        } else {
            $project->end_time = "";
        }
        return view('frontend.CompanyProjectDetail', compact('project'));
    }
}
