<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Page;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class ContactController extends Controller
{
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(String $slug = "contact")
    {
        $cacheDuration=env("CACHE_DURATION");
        $page = Cache::remember('page.slug.'.$slug, $cacheDuration, function () use($slug){
            return Page::where(['slug' => $slug, 'status' => 'ACTIVE'])->firstOrFail();
        });


        return Inertia::render('Contact/Index',
        [
            "page" => $page,
        ])
        ->withViewData(['title' => $page->title,'description' => $page->meta_description,'url' => $page->slug]);
    }

    
    public function sendMail(Request $request){

        $validated = $request->validate([
            'contactName' => 'required',
            'contactEmail' => 'email:rfc,dns',
            'contactMessage' => 'required',
            'honeypot' => 'present|max:0',
        ]);

        $contact = [
            'fullname' => $request['contactName'], 
            'email' => $request['contactEmail'],
            'subject' => "Contact Form email",
            'message' => $request['contactMessage'],
        ];

    
        Mail::to('info@laramotely.com')->send(new ContactFormMail($contact));
        
        return redirect()->route('contact')->with('status', 'Your message has been sent');
    }

}
