<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\GenerateMail;
use App\Models\{User, Offer, Project, ContactUs, DeleteAccountRequest, Review, OngoingProject, ProjectPayment, Subscription, SubscriptionPlan, PlanCharge};
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public  function dashboard()
    {
        $six_months_name = $this->six_months_name();
        $eight_months_name = $this->eight_months_name();
        $twelve_months_name = $this->twelve_months_name();
        $totall_projects = $this->totall_projects();
        $company_users = $this->company_users();
        $private_users = $this->private_users();
        $completed_projects = $this->completed_projects();
        $detail_graph = $this->detail_graph();
        $subscriptions = $this->subscriptions();
        $project_payment = $this->project_payments();
        $subscription_payment = $this->subscription_payments();


        // free subscription data 
        $free_subscription = Offer::where('type', 2)->first();

        // free projects data 
        $free_projects = Offer::where('type', 1)->first();


        $response = [
            "six_months_name" => $six_months_name,
            'eight_months_name' => $eight_months_name,
            'twelve_months_name' => $twelve_months_name,
            'totall_projects' => $totall_projects,
            'company_users' => $company_users,
            'private_users' => $private_users,
            'completed_projects' => $completed_projects,
            'detail_graph' => $detail_graph,
            'subscriptions' => $subscriptions,
            'project_payment' => $project_payment,
            'subscription_payment' => $subscription_payment,
            'free_subscription' => $free_subscription ?? '',
            'free_projects' => $free_projects ?? ''

        ];

        // dd($response);
        return view('frontend.Dashboard', compact('response'));
    }


    public  function six_months_name()
    {
        $current_month_name = Carbon::now()->isoFormat('MMM');
        $second_month_name = Carbon::now()->subMonthsNoOverflow(1)->isoFormat('MMM');
        $third_month_name = Carbon::now()->subMonthsNoOverflow(2)->isoFormat('MMM');
        $fourth_month_name = Carbon::now()->subMonthsNoOverflow(3)->isoFormat('MMM');
        $five_month_name = Carbon::now()->subMonthsNoOverflow(4)->isoFormat('MMM');
        $six_month_name = Carbon::now()->subMonthsNoOverflow(5)->isoFormat('MMM');
        $months = [
            $six_month_name,
            $five_month_name,
            $fourth_month_name,
            $third_month_name,
            $second_month_name,
            $current_month_name,
        ];
        return $months;
    }
    public  function eight_months_name()
    {
        $current_month_name = Carbon::now()->isoFormat('MMM');
        $second_month_name = Carbon::now()->subMonthsNoOverflow(1)->isoFormat('MMM');
        $third_month_name = Carbon::now()->subMonthsNoOverflow(2)->isoFormat('MMM');
        $fourth_month_name = Carbon::now()->subMonthsNoOverflow(3)->isoFormat('MMM');
        $five_month_name = Carbon::now()->subMonthsNoOverflow(4)->isoFormat('MMM');
        $six_month_name = Carbon::now()->subMonthsNoOverflow(5)->isoFormat('MMM');
        $seven_month_name = Carbon::now()->subMonthsNoOverflow(6)->isoFormat('MMM');
        $eight_month_name = Carbon::now()->subMonthsNoOverflow(7)->isoFormat('MMM');

        $months = [
            $eight_month_name,
            $seven_month_name,
            $six_month_name,
            $five_month_name,
            $fourth_month_name,
            $third_month_name,
            $second_month_name,
            $current_month_name,
        ];
        return $months;
    }
    public  function twelve_months_name()
    {
        $current_month_name = Carbon::now()->isoFormat('MMM');
        $second_month_name = Carbon::now()->subMonthsNoOverflow(1)->isoFormat('MMM');
        $third_month_name = Carbon::now()->subMonthsNoOverflow(2)->isoFormat('MMM');
        $fourth_month_name = Carbon::now()->subMonthsNoOverflow(3)->isoFormat('MMM');
        $five_month_name = Carbon::now()->subMonthsNoOverflow(4)->isoFormat('MMM');
        $six_month_name = Carbon::now()->subMonthsNoOverflow(5)->isoFormat('MMM');
        $seven_month_name = Carbon::now()->subMonthsNoOverflow(6)->isoFormat('MMM');
        $eight_month_name = Carbon::now()->subMonthsNoOverflow(7)->isoFormat('MMM');
        $ninth_month_name = Carbon::now()->subMonthsNoOverflow(8)->isoFormat('MMM');
        $tenth_month_name = Carbon::now()->subMonthsNoOverflow(9)->isoFormat('MMM');
        $eleventh_month_name = Carbon::now()->subMonthsNoOverflow(10)->isoFormat('MMM');
        $twelvth_month_name = Carbon::now()->subMonthsNoOverflow(11)->isoFormat('MMM');


        $months = [
            $twelvth_month_name,
            $eleventh_month_name,
            $tenth_month_name,
            $ninth_month_name,
            $eight_month_name,
            $seven_month_name,
            $six_month_name,
            $five_month_name,
            $fourth_month_name,
            $third_month_name,
            $second_month_name,
            $current_month_name,
        ];
        return $months;
    }

    public function totall_projects()
    {
        $months = 12;
        $last_twelve_months_projects = [];
        $totall_projects = Project::count();
        $current_month = Carbon::now();
        $current_month_data = Project::whereMonth('created_at', $current_month->month)
            ->whereYear('created_at', $current_month->year)
            ->count();
        if ($totall_projects > 0) {
            $current_month_project = round(($current_month_data / $totall_projects) * 100, 0);
        } else {
            $current_month_project = 0;
        }

        for ($i = 0; $i < $months; $i++) {
            $month = Carbon::now()->subMonths($i);
            $projects = Project::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            if ($totall_projects > 0) {
                $project_percentage = round(($projects / $totall_projects) * 100, 0);
                $last_twelve_months_projects[] = $project_percentage;
            } else {
                $last_twelve_months_projects[] = 0;
            }
        }
        $last_twelve_months_projects = array_reverse($last_twelve_months_projects);

        $data = [
            'last_twelve_months_projects' => $last_twelve_months_projects,
            'current_month_project' => $current_month_project,
            'total_projects' => $totall_projects,
        ];
        return $data;
    }

    public function company_users()
    {
        $months = 12;
        $last_twelve_months_users = [];
        $totall_users = User::where('user_type', 'company')->count();
        $current_month = Carbon::now();
        $current_month_data = User::where('user_type', 'company')->whereMonth('created_at', $current_month->month)
            ->whereYear('created_at', $current_month->year)
            ->count();
        if ($totall_users > 0) {
            $current_month_user = round(($current_month_data / $totall_users) * 100, 0);
        } else {
            $current_month_user = 0;
        }
        for ($i = 0; $i < $months; $i++) {
            $month = Carbon::now()->subMonths($i);
            $user = User::where('user_type', 'company')->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            if ($totall_users > 0) {
                $project_percentage = round(($user / $totall_users) * 100, 0);
                $last_twelve_months_users[] = $project_percentage;
            } else {
                $last_twelve_months_users[] = 0;
            }
        }
        $last_twelve_months_users = array_reverse($last_twelve_months_users);

        $data = [
            'last_twelve_months_users' => $last_twelve_months_users,
            'current_month_user' => $current_month_user,
            'totall_users' => $totall_users,
        ];
        return $data;
    }

    public function private_users()
    {
        $months = 6;
        $last_twelve_months_users = [];
        $totall_users = User::where('user_type', 'user')->count();
        $current_month = Carbon::now();
        $current_month_data = User::where('user_type', 'user')->whereMonth('created_at', $current_month->month)
            ->whereYear('created_at', $current_month->year)
            ->count();
        if ($totall_users > 0) {
            $current_month_user = round(($current_month_data / $totall_users) * 100, 0);
        } else {
            $current_month_user = 0;
        }
        for ($i = 0; $i < $months; $i++) {
            $month = Carbon::now()->subMonths($i);
            $user = User::where('user_type', 'user')->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            if ($totall_users > 0) {
                $project_percentage = round(($user / $totall_users) * 100, 0);
                $last_twelve_months_users[] = $project_percentage;
            } else {
                $last_twelve_months_users[] = 0;
            }
        }
        $last_twelve_months_users = array_reverse($last_twelve_months_users);

        $data = [
            'last_twelve_months_users' => $last_twelve_months_users,
            'current_month_user' => $current_month_user,
            'totall_users' => $totall_users,
        ];
        return $data;
    }

    public function completed_projects()
    {
        $months = 6;
        $last_twelve_months_projects = [];
        $totall_projects = Project::where('status', 3)->count();
        $current_month = Carbon::now();
        $current_month_data = Project::where('status', 3)->whereMonth('created_at', $current_month->month)
            ->whereYear('created_at', $current_month->year)
            ->count();
        if ($totall_projects > 0) {
            $current_month_project = round(($current_month_data / $totall_projects) * 100, 0);
        } else {
            $current_month_project = 0;
        }
        for ($i = 0; $i < $months; $i++) {
            $month = Carbon::now()->subMonths($i);
            $projects = Project::where('status', 3)->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            if ($totall_projects > 0) {
                $project_percentage = round(($projects / $totall_projects) * 100, 0);
                $last_twelve_months_projects[] = $project_percentage;
            } else {
                $last_twelve_months_projects[] = 0;
            }
        }
        $last_twelve_months_projects = array_reverse($last_twelve_months_projects);

        $data = [
            'last_twelve_months_projects' => $last_twelve_months_projects,
            'current_month_project' => $current_month_project,
            'total_projects' => $totall_projects,
        ];
        return $data;
    }

    public function detail_graph()
    {
        $months = 6;
        $last_twelve_months_projects = [];
        $last_twelve_months_company = [];
        $last_twelve_months_users = [];



        $totall_projects = Project::count();
        $totall_users = User::where('user_type', 'user')->count();
        $totall_company = User::where('user_type', 'company')->count();

        for ($i = 0; $i < $months; $i++) {
            $month = Carbon::now()->subMonths($i);
            $projects = Project::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            $last_twelve_months_projects[] = $projects;

            $user = User::where('user_type', 'user')->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            $last_twelve_months_users[] = $user;

            $company = User::where('user_type', 'company')->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
            $last_twelve_months_company[] = $company;
        }
        $last_twelve_months_projects = array_reverse($last_twelve_months_projects);
        $last_twelve_months_users = array_reverse($last_twelve_months_users);
        $last_twelve_months_company = array_reverse($last_twelve_months_company);




        $data = [
            'last_twelve_months_projects' => $last_twelve_months_projects,
            'last_twelve_months_users' => $last_twelve_months_users,
            'last_twelve_months_company' => $last_twelve_months_company
        ];
        return $data;
    }

    public function subscriptions()
    {
        $totall_subscription =  Subscription::where('status', 1)->count();
        $current_month = Carbon::now();
        $current_month_data = Subscription::where('status', 1)->whereMonth('created_at', $current_month->month)
            ->whereYear('created_at', $current_month->year)
            ->count();
        if ($totall_subscription > 0) {
            $current_month_subscription = round(($current_month_data / $totall_subscription) * 100, 0);
        } else {
            $current_month_subscription = 0;
        }
        $total_basic = Subscription::where([
            'status' =>  1,
            'plan_id' => 1
        ])->count();

        $total_pro = Subscription::where([
            'status' =>  1,
            'plan_id' => 2
        ])->count();

        $total_premium = Subscription::where([
            'status' =>  1,
            'plan_id' => 3
        ])->count();


        if ($totall_subscription > 0) {
            $basic = round((($total_basic / $totall_subscription) * 100), 0);
            $pro = round((($total_pro / $totall_subscription) * 100), 0);
            $premium = round((($total_premium / $totall_subscription) * 100), 0);
        } else {
            $basic = 0;
            $pro = 0;
            $premium = 0;
        }


        $data = [
            'total_basic' => $total_basic,
            'total_pro' => $total_pro,
            'total_premium' => $total_premium,
            'basic' => $basic,
            'pro' => $pro,
            'premium' => $premium,
            'totall_subscription' => $totall_subscription,
            'current_month_subscription' => $current_month_subscription
        ];
        return $data;
    }

    public function project_payments()
    {

        $months = 6;
        $last_twelve_months_payments = [];

        $totall_payment =  ProjectPayment::sum('price');

        $current_month = Carbon::now();
        $current_month_data = ProjectPayment::whereMonth('created_at', $current_month->month)
            ->whereYear('created_at', $current_month->year)
            ->sum('price');
        if ($totall_payment > 0) {
            $current_month_payments = round(($current_month_data / $totall_payment) * 100, 0);
        } else {
            $current_month_payments = 0;
        }
        for ($i = 0; $i < $months; $i++) {
            $month = Carbon::now()->subMonths($i);
            $payments = ProjectPayment::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('price');
            if ($totall_payment > 0) {
                $payment_percentage = round(($payments / $totall_payment) * 100, 0);
                $last_twelve_months_payments[] = $payment_percentage;
            } else {
                $last_twelve_months_payments[] = 0;
            }
        }
        $last_twelve_months_payments = array_reverse($last_twelve_months_payments);

        $data = [
            'totall_payments' => $totall_payment,
            'current_month_payments' => $current_month_payments,
            'last_twelve_months_payments' => $last_twelve_months_payments
        ];
        return $data;
    }

    public function subscription_payments()
    {

        $months = 8;
        $last_twelve_months_payments = [];

        $charges_id =  Subscription::where('status', 1)->pluck('charges_id')->toArray();


        $totall_payment = 0;
        foreach ($charges_id as $row) {
            $price = PlanCharge::where('id', $row)->first();
            $totall_payment = $totall_payment + $price->price;
        }

        $current_month = Carbon::now();
        $current_month_charges_id = Subscription::whereMonth('created_at', $current_month->month)
            ->whereYear('created_at', $current_month->year)->where('status', 1)
            ->pluck('charges_id')->toArray();
        $current_month_data = 0;
        foreach ($current_month_charges_id as $row) {
            $price = PlanCharge::where('id', $row)->first();
            $current_month_data = $current_month_data + $price->price;
        }
        if ($totall_payment > 0) {
            $current_month_payments = round(($current_month_data / $totall_payment) * 100, 0);
        } else {
            $current_month_payments = 0;
        }
        for ($i = 0; $i < $months; $i++) {
            $month = Carbon::now()->subMonths($i);
            $monthly_charges_id = Subscription::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->where('status', 1)
                ->pluck('charges_id')->toArray();

            $payments = 0;
            foreach ($monthly_charges_id as $row) {
                $price = PlanCharge::where('id', $row)->first();
                $payments = $payments + $price->price;
            }

            if ($totall_payment > 0) {
                $payment_percentage = round(($payments / $totall_payment) * 100, 0);
                $last_twelve_months_payments[] = $payment_percentage;
            } else {
                $last_twelve_months_payments[] = 0;
            }
        }
        $last_twelve_months_payments = array_reverse($last_twelve_months_payments);
        $data = [
            'totall_payments' => $totall_payment,
            'current_month_payments' => $current_month_payments,
            'last_twelve_months_payments' => $last_twelve_months_payments
        ];
        return $data;
    }


    public  function mail()
    {

        return view('frontend.Mails');
    }

    public  function send_email(Request $request)
    {
        $userType = $request->input('user_type');
        $message = $request->input('message');

        if ($userType == 'user') {
            $data = User::where('user_type', 'user')->get();
        } else if ($userType == 'company') {
            $data = User::where('user_type', 'company')->get();
        } else {
            $data = User::pluck('email')->get();
        }

        foreach ($data as $row) {

            $email = $row->email;
            $user_name = $row->name;
            $main_data = ['message' => $message, 'userName' => $user_name];
            Mail::to($email)->send(new GenerateMail($main_data));
        }

        return response()->json([
            'success' => true,
        ]);
    }


    public  function free_subscription(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $title = $request->input('title');
        $description = $request->input('description');
        $type = $request->input('type');

        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'title' => $title,
            'description' => $description,
            'type' => $type,
        ];

        $create = Offer::create($data);


        return back();
    }
    public  function remove_free_subscription(Request $request)
    {

        $remove = Offer::where('type', 2)->delete();
        return back();
    }

    public  function free_projects(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $title = $request->input('title');
        $description = $request->input('description');
        $type = $request->input('type');

        $data = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'title' => $title,
            'description' => $description,
            'type' => $type,
        ];

        $create = Offer::create($data);


        return back();
    }
    public  function remove_free_projects(Request $request)
    {

        $remove = Offer::where('type', 1)->delete();
        return back();
    }


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



    public  function contact_us()
    {
        $data = ContactUs::get();
        return view('frontend.ContactList', compact('data'));
    }

    public function get_contact_list(Request $request)
    {
        $searchTerm = $request->input('search');
        $query = ContactUs::orderBy('created_at', 'asc');

        if ($searchTerm) {
            $query->where('email', 'LIKE', '%' . $searchTerm . '%');
        }

        $users = $query->paginate(10);

        return response()->json(['users' => $users]);
    }


    public  function delete_account_requests()
    {
        $data = DeleteAccountRequest::get();
        return view('frontend.DeleteAccountRequest', compact('data'));
    }

    public function get_delete_account_requests(Request $request)
    {
        $searchTerm = $request->input('search');
        $query = DeleteAccountRequest::orderBy('created_at', 'asc');

        if ($searchTerm) {
            $query->where('email', 'LIKE', '%' . $searchTerm . '%');
        }

        $users = $query->paginate(10);

        return response()->json(['users' => $users]);
    }

    public function delete_request_detail(Request $request, $email)
    {
        $user = User::where('email', $email)->first();
        $user_type = $user->user_type;
        if ($user_type == 'company') {
            return redirect()->route('CompanyDetail', ['id' => $user->id]);
        } else {
            return redirect()->route('UserDetail', ['id' => $user->id]);
        }
    }
}
