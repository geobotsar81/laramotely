<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Email;
use App\Mail\NewsletterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendTodaysEmails()
    {

        $jobs = Job::laravel()->notother()->whereDate('created_at','>=',Carbon::yesterday())->whereDate('posted_date','>=',Carbon::yesterday())->orderBy('posted_date','desc')->take(10)->get();
        $contacts=Email::where('email','geobotsar@hotmail.com')->get();

        if(!empty($jobs)){
            if(!empty($contacts)){
                foreach($contacts as $contact){
                Mail::to($contact->email)->send(new NewsletterMail($jobs,$contact));
                }
            }
        }
        
    }
}
