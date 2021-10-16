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
        //$contacts=Email::get();

        if(!empty($jobs)){
            Mail::to('geobotsar@hotmail.com')->send(new NewsletterMail($jobs));
        }else{
            dd("No jobs found");
        }
        
    }
}
