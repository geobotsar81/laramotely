<?php
namespace App\Services;

use App\Models\Job;
use App\Models\Email;
use App\Mail\NewsletterMail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class NewsletterService{

    public function sendEmails()
    {
        echo 'Got newsletter';
        $jobs = Job::laravel()->notother()->whereDate('created_at','>=',Carbon::yesterday())->whereDate('posted_date','>=',Carbon::yesterday())->orderBy('posted_date','desc')->take(10)->get();
        $contacts=Email::where('is_subscribed',1)->where('email','geobotsar@gmail.com')->get();
       

        if(!empty($jobs)){
            if(!empty($contacts)){
                foreach($contacts as $contact){
                    Mail::to($contact->email)->send(new NewsletterMail($jobs,$contact));
                    echo $contact->email;
                    echo $jobs->count()." jobs";
                    echo $contacts->count()." contacts";
                }
            }
        }

        
        
    }

}