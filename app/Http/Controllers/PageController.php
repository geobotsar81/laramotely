<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Inertia\Inertia;
use App\Models\Country;
use App\Models\Question;
use App\Mail\ContactForm;
use Illuminate\Http\Request;
use App\Imports\CountriesImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class PageController extends Controller
{
    /**
     * Show the welcome page
     *
     * @return void
     */
    public function showHome(){
        $page=getPageFromSlug("/");
        $data=[];

        $jobs=Job::orderBy('posted_date','desc')->paginate(8);

        if(!empty($page)){
            $data=['title' => $page->title,'description' => $page->meta_description,'url' =>route('home.show')];
        }

        $data['jobs']=$jobs;
        return Inertia::render('Home/Index',$data)->withViewData(['title' => $page->title,'description' => $page->meta_description,'url' => route('home.show')]);
    }


    /**
     * Show Get Help page
     *
     * @return void
     */    
    public function showGetHelp(){
        $page=getPageFromSlug("get-help");
        $meta=[];

        if(!empty($page)){
            $meta=['title' => $page->title,'description' => $page->meta_description,'url' =>route('contact.show')];
        }
        return Inertia::render('GetHelp',$meta)->withViewData(['title' => $page->title,'description' => $page->meta_description,'url' => route('contact.show')]);
    }

    /**
     * Send the Get Help email
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function sendMail(Request $request){
       
       $fromEmail=setting('mail.email_from');
       $toEmail=setting('mail.email_to');
      
        
        $validated = $request->validate([
            'contactName' => 'required',
            'contactEmail' => 'email:rfc,dns',
            'contactMessage' => 'required',
            'contactSubject' => 'required',
            'contactInquiry' => 'required',
            'honeypot' => 'present|max:0',
        ]);
       
        $contact = [
            'fullname' => $request['contactName'], 
            'email' => $request['contactEmail'],
            'subject' => $request['contactSubject'],
            'message' => $request['contactMessage'],
            'inquiry' => $request['contactInquiry'],
            'newsletter' => $request['contactNewsletter'],
            'from' => $fromEmail,
        ];

        Mail::to($toEmail)->send(new ContactForm($contact));
        
        return redirect()->back()->with('status', 'Your message has been sent');
    }

    
    
}
