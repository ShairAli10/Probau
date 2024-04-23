<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\{ResetPasswordRequests, UpdatePassword, VerifyOTPRequest};
use App\Http\Responses\ApiResponse;
use App\Models\CompanyType;
use App\Models\Notification;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\GenerateOTPMail;

class ForgotPasswordController extends Controller
{
    /**
     * The function generates a random OTP (One-Time Password) and sends it to the user's email address
     * for verification.
     * that the OTP is sent successfully, along with the OTP code. If the user's email is not found in
     * the database
     */
    public function generate_otp(Request $request)
    {
        $request->validate(['email' => 'required|string|email:rfc,dns',]);
        // generate random code
        $otp_code = mt_rand(1000, 9999);
        $user = User::where('email', $request->email)->update(['email_code' => $otp_code]);
        if ($user) {
            $main_data = ['message' => $otp_code];
            Mail::to($request->email)->send(new GenerateOTPMail($main_data));
            $data = [
                'status' => true,
                'message' => 'OTP sent Successfully',
                'OTP Code' => $otp_code,
            ];
            return response()->json($data, 200);
        } else {
            return ApiResponse::error();
        }
    }
    /**
     * The function `verify_otp` is used to validate an OTP (One-Time Password) provided by the user and
     * return a response indicating whether the OTP is correct or not.
     */
    public function verify_otp(VerifyOTPRequest $request)
    {

        $email = request('email');
        $otp = request('otp');
        $action = request('action');
        $user = User::with('company_type.services')->where([['email', $email], ['email_code', $otp]])->first();
        if ($user) {
            $user->email_verified = "1";
            $user->email_code = '';
            $user->save();
            $user['first_login'] = false;
            $user['distance'] = "";
            $user['totalProjects'] = 0;
            $user['saved'] = 0;
            $user['avgRating'] = 0;
            $user['totalRating'] = 0;
    
            $data = [
                'message' => 'OTP Verified',
                'status' => true,
                'data' => $user,
            ];
        
            if ($action == 1) {
                $data['user_token'] = $user->createToken('Probau')->plainTextToken;
                $device_id = $user->device_id;
                $notifTitle = "Welcome to ProBau";
                $notiBody = "Welcome to ProBau! Explore nearby businesses, read reviews, and take service by adding projects. Start discovering now!";
                $this->send_notification($device_id, $notifTitle, $notiBody);
                
                // save notification in database 
                $notiData = [
                    'user_id' => $user->id,
                    'title' => 'Welcome to ProBau',
                    'body' => $notiBody,
                    'type' => 'welcome',
                    'status' => 0
                ];

                $notification = Notification::create($notiData);
            }
        
            return response()->json($data, 200);
        }
        
        $data = ['status' => false, 'message' => 'Please enter valid OTP'];
        return response()->json($data, 400);
    }
    /**
     * The function `reset_password` is used to update the password of a user in the database based on
     * the provided user ID.
     */
    public function reset_password(ResetPasswordRequests $request)
    {

        $user = User::find(request('user_id'));
        if ($user !== null) {
            // update password in database
            $user->password = $request->password;
            $user->save();
            $data = [
                'status' => true,
                'message' => 'Password update successfully',
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'User Not Found in Database',
            ];
            return response()->json($data, 200);
        }
    }

    // update password

    public function update_password(UpdatePassword $request)
    {

        $user = User::find(request('user_id'));

        if ($user != null) {
            $password = $user->password;
            $check_password = Hash::check($request->old_password, $user->password);
            if ($check_password) {
                // update the user password in database.
                $check_new_password = Hash::check($request->new_password, $user->password);
                if ($check_new_password) {
                    $data = [
                        'message' => 'New password must be diffrent from old password',
                        'status' => false,
                        'data' => (object)[],
                    ];
                    return response()->json($data, 401);
                }
                $user->password = Hash::make($request->new_password);
                $user->save();

                $data = [
                    'message' => 'Password updated successfully',
                    'status' => true,
                    'data' => (object)[],
                ];
                return response()->json($data, 200);
            } else {
                $data = [
                    'message' => 'Old Password does not match.',
                    'status' => false,
                    'data' => (object)[],
                ];

                return response()->json($data, 401);
            }
        } else {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' => (object)[],
            ];

            return response()->json($data, 401);
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
