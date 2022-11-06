<?php
namespace App\Services;

use App\Models\Job;
use App\Models\AppMember;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class FirebaseNotificationService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = "AAAAhRMFNy8:APA91bElXgOvTHaZ_wVq8RZE6F3ZJQyAnYqQ6rkb-RQUao2TBKyUIaNWreF-LxbJAeLb4EdWUP4y3UQxVk9U2A5PcjXN8zV6kEcWCf0xPUTwX7ycIHVQ5Uug6szBWud5itC7HuHOYfzo";
    }

    public function sendNotification($registatoin_ids, $notification, $device_type)
    {
        $url = "https://fcm.googleapis.com/fcm/send";

        if ($device_type == "Android") {
            $fields = [
                "notification" => $notification,
                "to" => $registatoin_ids,
                "data" => $notification,
            ];
        } else {
            $fields = [
                "to" => $registatoin_ids,
                "notification" => $notification,
            ];
        }
        // Firebase API Key

        $headers = ["Authorization:key=" . $this->apiKey, "Content-Type:application/json"];
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        echo $result . "<br>";
        if ($result === false) {
            die("Curl failed: " . curl_error($ch));
        }
        curl_close($ch);
    }

    public function testJobNotifications()
    {
        $appToken = "en0kSdadSo6tHMMUha-u1I:APA91bE63pBprj5SfDt_O93cZArNqnMOldn-_LMfeID7rlpBG-yC4R9UG38wuUg9vBqGfo-dPP57bNMemRF5gunMKhc-TQFfNVcOENyblhtVunAapGE7Lto0JkLJPMavSM9IuRccn89y";
        $this->sendJobNotifications($appToken);
    }

    public function sendJobNotifications($appToken = null)
    {
        $deviceType = "Android";
        $current = Carbon::now();
        $hourOfTheDay = $current->format("H");

        $appMembers = AppMember::where("notificationsInterval", "!=", 0)->get();

        if ($appToken) {
            $appMembers = AppMember::where("notificationsInterval", "!=", 0)
                ->where("appToken", $appToken)
                ->get();
            Log::info(["count" => $appMembers->count()]);
        }

        if ($appMembers->count() > 0) {
            foreach ($appMembers as $member) {
                $appID = $member->appToken;
                $notificationsInterval = $member->notificationsInterval;
                $inCountries = $member->inCountries;

                Log::info([
                    "appID" => $appID,
                    "notificationsInterval" => $notificationsInterval,
                    "hourOfTheDay" => $hourOfTheDay,
                ]);

                //If the user's notifications interval is within the current hour, then send the notification
                if ($hourOfTheDay % $notificationsInterval == 0) {
                    $timeNow = $current->toDateTimeString();
                    $timeToBeat = $current->subHours($notificationsInterval)->toDateTimeString();

                    //Get jobs that were created within this hour interval, but not older than a week
                    $job = Job::laravel(false)
                        ->published()
                        ->notother()
                        ->where("created_at", ">=", $timeToBeat)
                        ->where("posted_date", ">=", Carbon::now()->subDays(7));

                    if (!empty($inCountries)) {
                        $countriesArray = explode(",", $inCountries);
                        $job = $job->inCountries($countriesArray);
                    }

                    $job = $job->orderBy("views", "desc")->first();

                    if (empty($job)) {
                        //Get jobs that were created within this hour interval, but not older than 2 weeks

                        $job = Job::laravel(false)
                            ->published()
                            ->notother()
                            ->where("created_at", ">=", $timeToBeat)
                            ->where("posted_date", ">=", Carbon::now()->subDays(14));

                        if (!empty($inCountries)) {
                            $countriesArray = explode(",", $inCountries);
                            $job = $job->inCountries($countriesArray);
                        }

                        $job = $job->orderBy("views", "desc")->first();
                    }

                    Log::info([
                        "time-now" => $timeNow,
                        "time-to-beat" => $timeToBeat,
                    ]);

                    if (!empty($job)) {
                        Log::info([
                            "id" => $job->id,
                            "title" => $job->title,
                            "created_at" => $job->created_at->format("d-m-y H:i:s"),
                        ]);

                        $notification = [];
                        $notification["body"] = $job->company . " is looking for a " . $job->title . ". Location: " . $job->location;
                        $notification["title"] = $job->title;
                        $notification["sound"] = "default";
                        $notification["type"] = 1;
                        $notification["section"] = "job";
                        $notification["id"] = $job->id;
                        $notification["notification_foreground"] = "true";
                        $notification["icon"] = "notification_icon";

                        $this->sendNotification($appID, $notification, $deviceType);
                    }
                }
                Log::info("----------------------------");
            }
        }
    }
}
