<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\{User, Project, Notification};
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class AutoNotificationForProject implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $project_id;
    /**
     * Create a new job instance.
     *  @param int $project_id
     */
    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $project_id =  $this->project_id;
        $project = Project::find($project_id);
        $project_services = $project->services;
        $user_id = $project->user_id;
        $user = User::find($user_id);
        $user_name = $user->name;
        $project_lat = $project->lat;
        $project_long = $project->long;
        $companies = User::where('user_type', 'company')
            ->where(function ($query) use ($project_services) {
                foreach ($project_services as $projectService) {
                    $query->orWhere(function ($subquery) use ($projectService) {
                        $subquery->whereJsonContains('services', $projectService);
                    });
                }
            })
            ->where('id', '!=', $user_id)
            ->selectRaw(
                'users.id, users.name,users.device_id,users.notification_range, ' .
                    '( 6371 * acos( cos( radians(?) ) * cos( radians( users.lat ) ) * cos( radians( users.long ) - radians(?) ) + sin( radians(?) ) * sin( radians( users.lat ) ) ) ) AS distance',
                [$project_lat, $project_long, $project_lat]
            )
            ->groupBy('users.id', 'users.name', 'users.lat', 'users.long', 'users.device_id', 'users.notification_range') // Add all other selected columns
            ->having('distance', '<=', DB::raw('users.notification_range'))
            ->get();

        foreach ($companies as $company) {
            // send notiofication to the company user 
            $device_id = $company->device_id;
            $notifTitle = "A new match";
            $notiBody = $user_name . ' ' . 'added a new project that matches your profile';
            $this->send_notification($device_id, $notifTitle, $notiBody);

            // save notification in database 
            $notiData = [
                'user_id' => $company->id,
                'title' => $notifTitle,
                'body' => $notiBody,
                'data_id' => $project_id,
                'type' => 'new_match',
                'status' => 0
            ];

            $notification = Notification::create($notiData);
        }
    }

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
            'message_Type' => 'new_match',
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
