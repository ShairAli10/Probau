<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Mail\GenerateOTPMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;;

class AdminController extends Controller
{

  
    public function login()
    {
        return view('frontend.login');
    }


    public function loginn(Request $request)
    {
        // if(Request::ajax()){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $admin = Admin::where('email', '=', $request->email)->first();
        if ($admin) {
            if ($request->password == $admin->password) {
                $request->session()->put('email', $admin->email);
                $request->session()->put('name', $admin->name);
                $request->session()->put('loginId', $admin->id);
                $admin->save();
                $data = array(
                    'response' => 'success',
                    'message' => "Login successfull"
                );
            } else {
                $data = array(
                    'response' => 'error',
                    'message' => "invalid"
                );
            }
        } else {
            $data = array(
                'response' => 'error',
                'message' => "invalid"
            );
        }
        echo json_encode($data);
    }


    public function flush(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    public function forgot_password()
    {
        return view('frontend.ForgotPassword');
    }

    public function send_otp(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'email' => 'required|email',
        ]);
        // generate random code
        $otp_code = mt_rand(1000, 9999);

        $user = Admin::where('email', $request->email)->first();

        if ($user) {
            $user->email_code = $otp_code;
            $user->save();
            $data = ['message' => 'Probau' . $otp_code];
            Mail::to($request->email)->send(new GenerateOTPMail($data));

            $data = array(
                'response' => 'success',
                'message' => "Login successfull"
            );
        } else {
            $data = array(
                'response' => 'error',
                'message' => "invalid"
            );
        }
        echo json_encode($data);
    }

    function verify_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email:rfc,dns',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }
        $email = request('email');
        $status = Admin::where('email', request('email'))->where('email_code', request('otp'))->first();


        if ($status != null) {
            $request->session()->put('email', $status->email);
            $request->session()->put('name', $status->name);
            $request->session()->put('loginId', $status->id);
            $status->save();
            $data = [
                'message' => 'OTP Verified',
                'status' => true,
                'data' => [
                    'user' => $status,
                ],
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => false,
                'message' => 'Incorrect OTP ',
            ];
            return response()->json($data, 401);
        }
    }

    public function change_password()
    {
        return view('frontend.ResetPassword');
    }
    function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }
        $email = session('email');
        $status = Admin::where('email', $email)->update(['password' => request('password')]);
        $data = [
            'response' => 'success',
            'status' => true,
            'message' => 'Password update successfully',
        ];
        echo json_encode($data);
    }
}
