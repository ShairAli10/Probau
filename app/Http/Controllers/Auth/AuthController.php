<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\{LoginRequest, RegisterRequest, SocialRequest, UpdateDeviceID, UpdateFirebaseid};
use App\Models\CompanyType;
use App\Models\Notification;
use App\Models\User;
use App\Models\Service;
use App\Models\UserCompanyServices;
use App\Models\UserCompanyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * The function registers a user by validating the input, creating a new user record, generating a
     * token, and returning the user data with the token.
     */
    public function sign_up(RegisterRequest $request)
    {
        $check_email =  User::where('email', $request->email)->first();
        if ($check_email) {
            $data = [
                'message' => 'This email is already connected to an account in our database',
                'status' => false,
                'data' => [],
            ];

            return response($data, 200);
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'user_type' => $request->user_type,
            'company_tax' => $request->company_tax ?? '',
            'no_employee' => $request->no_employee ?? '',
            'device_id' => $request->device_id ?? '',
        ];
        $user = User::create($data);
        $company_type_data = [];
        $serviceData = [];
        $company_type = $request->company_type;
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
        $user->save();
        $user_data = User::with('company_type.services')->where('id', $user->id)->first();
        $user_data['first_login'] = false;
        $user_data['distance'] = "";
        $user_data['totalProjects'] = 0;
        $user_data['saved'] = 0;
        $user_data['avgRating'] = 0;
        $user_data['totalRating'] = 0;
        $response = [
            'message' => 'Successfully registered!',
            'status' => true,
            'data' => $user_data,
        ];
        return response()->json($response, 200);
    }
    /**
     * The login function attempts to authenticate a user with the provided email and password, revokes
     * any previous tokens, generates a new token, and returns a JSON response with the user data and
     * token if successful, or an unauthorized response if unsuccessful.
     */
    public function sign_in(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user()->load('company_type.services');

            $user['first_login'] = false;
            $user['distance'] = "";
            $user['totalProjects'] = 0;
            $user['saved'] = 0;
            $user['avgRating'] = 0;
            $user['totalRating'] = 0;
            // Revoke previous token if exists
            $user->tokens()->delete();
            $response = [
                'message' => 'Successfully logged In!',
                'status' => true,
                'data' => $user,
                'user_token' => $user->createToken('Probau')->plainTextToken,
            ];
            return response()->json($response, 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials',
            ], 401);
        }
    }
    /**  social login where you can signIn/SignUp using social app this api run on base of social token that
     * provide google or apple.
     */
    public function social_login(SocialRequest $request)
    {
        $social_key = $request->social_key;
        $social_token = $request->social_token;
        $email = $request->email;
        $name = $request->name;
        $user_type = $request->user_type;
        $device_id = $request->device_id;
        if ($social_key == 'google') {
            $check_socail_token = User::with('company_type.services')->where('g_token', '=', $social_token)->first();
            if ($check_socail_token) {
                if ($user_type == 'user') {
                    $check_socail_token['first_login'] = false;
                } else {
                    if (
                        $check_socail_token->phone == ''
                    ) {
                        $check_socail_token['first_login'] = true;
                    } else {
                        $check_socail_token['first_login'] = false;
                    }
                }
                $check_socail_token['distance'] = "";
                $check_socail_token['totalProjects'] = 0;
                $check_socail_token['saved'] = 0;
                $check_socail_token['avgRating'] = 0;
                $check_socail_token['totalRating'] = 0;
        
                // Revoke previous token if exists
                DB::table('personal_access_tokens')
                    ->where('tokenable_type', get_class($check_socail_token))
                    ->where('tokenable_id', $check_socail_token->id)
                    ->delete();
                $data = [
                    'message' => 'User Details',
                    'status' => true,
                    'data' => $check_socail_token,
                    'user_token' => $check_socail_token->createToken('Probau')->plainTextToken


                ];

                return response($data, 200);
            } else {
                $signup = new User();
                if (!empty($name)) {
                    $signup->name = $name;
                }
                if (!empty($email)) {
                    $signup->email = $email;
                }
                if (!empty($device_id)) {
                    $signup->device_id = $device_id;
                }
                $signup->status = 1;
                $signup->g_token = $social_token;
                $signup->user_type = $user_type;
                $signup->save();
                $id = $signup->id;
                $data = User::with('company_type.services')->find($id);
                if ($user_type == 'user') {
                    $data['first_login'] = false;
                } else {
                    $data['first_login'] = true;
                }
                $data['distance'] = "";
                $data['totalProjects'] = 0;
                $data['saved'] = 0;
                $data['avgRating'] = 0;
                $data['totalRating'] = 0;
                $device_id = $signup->device_id;
                $notifTitle = "Welcome to ProBau";
                $notiBody = "Welcome to ProBau! Explore nearby businesses, read reviews, and take service by adding projects. Start discovering now!";
                $this->send_notification($device_id, $notifTitle, $notiBody);

                // save notification in database 
                $notiData = [
                    'user_id' => $signup->id,
                    'title' => 'Welcome to ProBau',
                    'body' => $notiBody,
                    'type' => 'welcome',
                    'status' => 0
                ];

                $notification = Notification::create($notiData);
                $data = [
                    'message' => 'User Signup Successfully',
                    'status' => true,
                    'data' => $data,
                    'user_token' => $data->createToken('Probau')->plainTextToken


                ];

                return response($data, 200);
            }
        }
        if ($social_key == 'apple') {
            $check_socail_token = User::with('company_type.services')->where('a_code', '=', $social_token)->first();
            if ($check_socail_token) {
                if ($check_socail_token->name == null) {
                    $check_socail_token->name = ' ';
                }
                if ($check_socail_token->email == null) {
                    $check_socail_token->email = ' ';
                }
                if ($user_type == 'user') {
                    $check_socail_token['first_login'] = false;
                } else {
                    if (
                        $check_socail_token->phone == ''
                    ) {
                        $check_socail_token['first_login'] = true;
                    } else {
                        $check_socail_token['first_login'] = false;
                    }
                }
                $check_socail_token['distance'] = "";
                $check_socail_token['totalProjects'] = 0;
                $check_socail_token['saved'] = 0;
                $check_socail_token['avgRating'] = 0;
                $check_socail_token['totalRating'] = 0;
                // Revoke previous token if exists
                DB::table('personal_access_tokens')
                    ->where('tokenable_type', get_class($check_socail_token))
                    ->where('tokenable_id', $check_socail_token->id)
                    ->delete();
                $data = [
                    'message' => 'User Details',
                    'status' => true,
                    'data' => $check_socail_token,
                    'user_token' => $check_socail_token->createToken('Probau')->plainTextToken
                ];

                return response($data, 200);
            } else {
                $signup = new User();
                if (!empty($name)) {
                    $signup->name = $name;
                }
                if (!empty($email)) {
                    $signup->email = $email;
                }
                if (!empty($device_id)) {
                    $signup->device_id = $device_id;
                }
                $signup->status = 1;
                $signup->a_code = $social_token;
                $signup->user_type = $user_type;
                $signup->save();
                $id = $signup->id;
                $data = User::with('company_type.services')->find($id);
                if ($data->name == null) {
                    $data->name = ' ';
                }
                if ($data->email == null) {
                    $data->email = ' ';
                }
                if ($user_type == 'user') {
                    $data['first_login'] = false;
                } else {
                    $data['first_login'] = true;
                }
                $data['distance'] = "";
                $data['totalProjects'] = 0;
                $data['saved'] = 0;
                $data['avgRating'] = 0;
                $data['totalRating'] = 0;
                $device_id = $signup->device_id;
                $notifTitle = "Welcome to ProBau";
                $notiBody = "Welcome to ProBau! Explore nearby businesses, read reviews, and take service by adding projects. Start discovering now!";
                $this->send_notification($device_id, $notifTitle, $notiBody);

                // save notification in database 
                $notiData = [
                    'user_id' => $signup->id,
                    'title' => 'Welcome to ProBau',
                    'body' => $notiBody,
                    'type' => 'welcome',
                    'status' => 0
                ];

                $notification = Notification::create($notiData);

                $data = [
                    'message' => 'User Signup Successfully',
                    'status' => true,
                    'data' => $data,
                    'user_token' => $data->createToken('Probau')->plainTextToken


                ];
                return response($data, 200);
            }
        }
    }


    // update device id 

    public function update_device_id(UpdateDeviceID $request)
    {

        $user_id = $request->user_id;
        $device_id = $request->device_id;

        $user = User::find($user_id);
        if ($user) {
            $user->device_id = $device_id;
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User Not Found',
            ], 200);
        }
    }
    // update Firebase id 

    public function update_firebase_id(UpdateFirebaseid $request)
    {

        $user_id = $request->user_id;
        $firebase_id = $request->firebase_id;

        $user = User::find($user_id);
        if ($user) {
            $user->firebase_id = $firebase_id;
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User Not Found',
            ], 200);
        }
    }

    public function logout(Request $request)
    {

        $user_id = request('user_id');

        $user = User::find($user_id);
        if ($user) {
            $user->device_id = '';
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'logged out successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User Not Found',
            ], 200);
        }
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
}
