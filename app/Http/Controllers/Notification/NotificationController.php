<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\{User, CompanyType, Service, Project, SavedProject, ProjectRequest, Notification};
use App\Http\Requests\{SaveProject, Notifications};
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // get all notifications against user
    public function notification(Notifications $request)
    {
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $page_no = $request->page_no;
        
        if ($user == null) {
            $data = [
                'message' => 'User not found',
                'status' => false,
                'data' => (object) [],
            ];

            return response()->json($data, 200);
        }

        $perPage = 10;
        $offset = ($page_no - 1) * $perPage;

        // get all unread notifications of the user id 
        $notifications = Notification::skip($offset)->where('user_id', $user_id)->take($perPage)->orderBy('created_at', 'desc')->get();

        $totalPages = ceil(Notification::where(['user_id' => $user_id])->count() / $perPage);

        if (count($notifications) > 0) {
            $data = [
                'message' => 'Notifications Found',
                'status' => true,
                'data' => [
                    'page_data' => $notifications,
                    'total_pages' => $totalPages
                ]
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'No New Notifications',
                'status' => false,
                'data' => [
                    'page_data' => [],
                    'total_pages' => 0
                ]
            ];

            return response()->json($data, 200);
        }
    }

    // mark as read 
    public function mark_read(Request $request)
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

        // get all unread notifications of the user id 
        $notifications = Notification::where([
            'user_id' => $user_id,
            'status' => 0,
        ])->update(['status' => 1]);

        $data = [
            'message' => 'Marked all as read',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function read_single_notification(Request $request)
    {

        $notifiction_id = $request->notifiction_id;
        $notification = Notification::find($notifiction_id);
        if ($notification == null) {
            $data = [
                'message' => 'Notification data not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }

        // get all unread notifications of the user id 
        $notifications = Notification::where([
            'id' => $notifiction_id,
            'status' => 0,
        ])->update(['status' => 1]);

        $data = [
            'message' => 'Marked as read',
            'status' => true,
        ];

        return response()->json($data, 200);
    }

    public function delete_notification(Request $request)
    {
        $notifiction_id = $request->notifiction_id;
        $notification = Notification::find($notifiction_id);
        if ($notification == null) {
            $data = [
                'message' => 'Notification data not found',
                'status' => false,
            ];

            return response()->json($data, 200);
        }

        $notification->delete();

        $data = [
            'message' => 'deleted Successfully',
            'status' => true,
        ];

        return response()->json($data, 200);
    }
}
