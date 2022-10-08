<?php
namespace App\Services;

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
}
