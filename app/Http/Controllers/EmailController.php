<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Inertia\Inertia;
use App\Models\Email;
use App\Mail\NewsletterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class EmailController extends Controller
{
    public function sendTodaysEmails()
    {

        $jobs = Job::laravel()->notother()->whereDate('created_at','>=',Carbon::yesterday())->whereDate('posted_date','>=',Carbon::yesterday())->orderBy('posted_date','desc')->take(10)->get();
        $contacts=Email::where('is_subscribed',1)->where('email','geobotsar@hotmail.com')->get();

        if(!empty($jobs)){
            if(!empty($contacts)){
                foreach($contacts as $contact){
                    Mail::to($contact->email)->send(new NewsletterMail($jobs,$contact));
                }
            }
        }
        
    }

    /**
     * Unsubscribe a user from the email list
     *
     * @param String $encodedID
     * @return String
     */
    public function unsubscribe(String $encodedID)
    {
        $userID=Crypt::decryptString($encodedID);

        if(!empty($userID)){
            $email=Email::where('id',$userID)->get();
            if(!empty($email)){
                $email->is_subscribed=0;
                $email->save();
                $message="User unsubscribed successfully.";
            }else{$message="Could not unsubscribe user";}
        }else{$message="Could not unsubscribe user";}


        $page=getPageFromSlug("unsubscribe");
        $meta=[];

        if(!empty($page)){
            $meta=['title' => $page->title." - Laramotely",'description' => $page->meta_description,'url' =>route('contact.show')];
        }

        $meta['message']=$message;

        return Inertia::render('Newsletter/Unsubscribe',$meta)->withViewData(['title' => $page->title,'description' => $page->meta_description,'url' => route('newsletter.unsubscribe')]);
    }
}
