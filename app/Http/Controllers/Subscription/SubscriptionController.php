<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Models\{Offer, User, Subscription, SubscriptionPlan, PlanCharge, Project as ModelsProject, ProjectPayment as ModelsProjectPayment};
use App\Http\Requests\{Project, ProjectPayment, Subscribe, Users};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SubscriptionController extends Controller
{
    // plans get
    public function plans(Request $request)
    {
        $list = SubscriptionPlan::get();
        if ($list->isNotEmpty()) {
            $response = [
                'status' => true,
                'message' => 'Subscription Plans List',
                'data' => $list,
            ];
            return response()->json($response, 200);
        }
        $response = [
            'status' => false,
            'message' => 'No Subscription Plans Found in Database',
            'data' => [],
        ];
        return response()->json($response, 200);
    }

    // plan detail
    public function plan_detail(Request $request)
    {
        $plan_id = $request->plan_id;
        $plan = SubscriptionPlan::find($plan_id);
        if ($plan == null) {
            $data = [
                'message' => 'Plan not found',
                'status' => false,
                'data' => (object) [],
            ];
            return response()->json($data, 200);
        }
        $detail = PlanCharge::where('plan_id', $plan_id)->get();
        if ($detail->isNotEmpty()) {
            $response = [
                'status' => true,
                'message' => 'Plan Detail fetched successfully',
                'data' => $detail
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Data not found',
                'data' => []
            ];
            return response()->json($response, 200);
        }
    }

    //    
    public function subscribe(Subscribe $request)
    {
        $plan_id = $request->plan_id;
        $user_id = $request->user_id;
        $user = User::find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }
        $plan = SubscriptionPlan::find($plan_id);
        if ($plan == null) {
            $data = [
                'message' => 'Plan not found',
                'status' => false,
            ];
            return response()->json($data, 200);
        }

        $charges_id = $request->charges_id;
        $payment_id = $request->payment_id;
        $payment_method = $request->payment_method;

        // check if already subscribed
        $check = Subscription::where([
            'user_id' => $user_id,
            'plan_id' => $plan_id,
            'status' => 1
        ])->first();

        if ($check) {
            $data = [
                'message' => 'Already Subscribed',
                'status' => false,
            ];
            return response()->json($data, 200);
        }
        $detail = PlanCharge::where([
            'plan_id' =>  $plan_id,
            'id' => $charges_id
        ])->first();
        $validity = $detail->validity;
        $start_date = Carbon::now()->format('d/m/Y');
        $end_date = Carbon::now()->copy()->addMonths($validity)->format('d/m/Y');

        $data = [
            'user_id' => $user_id,
            'plan_id' => $plan_id,
            'charges_id' => $charges_id,
            'status' => 1,
            'payment_id' => $payment_id,
            'payment_method' => $payment_method,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        $create = Subscription::create($data);


        if ($create) {
            $response = [
                'status' => true,
                'message' => 'Subscribed successfully',
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to Subscribe',
            ];
            return response()->json($response, 200);
        }
    }

    // change plan
    public function change(Subscribe $request)
    {
        $plan_id = $request->plan_id;
        $user_id = $request->user_id;
        $user = User::find($user_id);
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }
        $plan = SubscriptionPlan::find($plan_id);
        if ($plan == null) {
            $data = [
                'message' => 'Plan not found',
                'status' => false,
            ];
            return response()->json($data, 200);
        }

        $charges_id = $request->charges_id;
        $payment_id = $request->payment_id;
        $payment_method = $request->payment_method;

        // check if already subscribed
        $check = Subscription::where([
            'user_id' => $user_id,
            'status' => 1
        ])->first();

        if ($check == null) {
            $data = [
                'message' => 'You dont have any active subscriptions before',
                'status' => false,
            ];
            return response()->json($data, 200);
        }

        // change the status of already subscribed subscription
        $check->status = 0;
        $check->save();

        $detail = PlanCharge::where([
            'plan_id' =>  $plan_id,
            'id' => $charges_id
        ])->first();
        $validity = $detail->validity;
        $start_date = Carbon::now()->format('d/m/Y');
        $end_date = Carbon::now()->copy()->addMonths($validity)->format('d/m/Y');

        $data = [
            'user_id' => $user_id,
            'plan_id' => $plan_id,
            'charges_id' => $charges_id,
            'status' => 1,
            'payment_id' => $payment_id,
            'payment_method' => $payment_method,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        $create = Subscription::create($data);


        if ($create) {
            $response = [
                'status' => true,
                'message' => 'Updated successfully',
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to Update',
            ];
            return response()->json($response, 200);
        }
    }

    // My Active subscription

    public function my_subscription(Users $request)
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

        // Here we will check if free subscription is available then we will return response with free subscription information along with plan detail of plan id 3 

        $check = Offer::where('type', 2)->first();
        if ($check) {
            return $this->free_subscription_model($user_id);
        }


        $subscription = Subscription::where([
            'user_id' => $user_id,
        ])->latest('created_at')->first();

        if ($subscription == null) {
            $data = [
                'message' => 'You dont have any active subscription',
                'status' => false,
                'data' => (object) []
            ];

            return response()->json($data, 200);
        }

        $subscription->title = "";
        $subscription->description = "";
        $subscription->free_subscription = false;

        $plan_detail = SubscriptionPlan::find($subscription->plan_id);

        $subscription->plan_detail = $plan_detail;

        $charges_detail = PlanCharge::where('id', $subscription->charges_id)->first();
        $subscription->charges_detail = $charges_detail;
        $data = [
            'message' => 'Your Active Subscription',
            'status' => true,
            'data' => $subscription
        ];

        return response()->json($data, 200);
    }

    // project payment history store 
    public function project_payment(ProjectPayment $request)
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
        $project_id = $request->project_id;
        $project = ModelsProject::find($project_id);
        if ($project == null) {
            $data = [
                'message' => 'Project not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }
        $price = $request->price;
        $payment_id = $request->payment_id;
        $payment_method = $request->payment_method;


        $data = [
            'user_id' => $user_id,
            'project_id' => $project_id,
            'price' => $price,
            'payment_id' => $payment_id,
            'payment_method' => $payment_method,
        ];

        $create = ModelsProjectPayment::create($data);
        $data = [
            'message' => 'Payment Successful',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    // user free subscription model
    public function free_subscription_model($user_id)
    {

        $subscription = Offer::where('type', 2)->select('id', 'title', 'description', 'start_date', 'end_date', 'created_at', 'updated_at')->first();
        $subscription->user_id = $user_id;
        $subscription->plan_id = "3";
        $subscription->charges_id = "8";
        $subscription->start_date = Carbon::parse($subscription->start_date)->format('d/m/Y');
        $subscription->end_date = Carbon::parse($subscription->end_date)->format('d/m/Y');
        $subscription->status = "1";
        $subscription->payment_id = "";
        $subscription->payment_method = "";
        $subscription->free_subscription = true;
        $subscription->plan_detail =  SubscriptionPlan::find(3);
        $subscription->charges_detail =PlanCharge::where('id', 8)->first();
        $data = [
            'message' => 'Your Active Subscription',
            'status' => true,
            'data' => $subscription
        ];

        return response()->json($data, 200);
    }
}
