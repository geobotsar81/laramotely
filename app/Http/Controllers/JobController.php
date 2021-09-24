<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Inertia\Inertia;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Page;
use Illuminate\Support\Facades\Cache;

class JobController extends Controller
{
    /**
     * Show the job
     * 
     * @return void
     */
    public function show($id){
       $job=Job::where('id',$id)->firstOrFail();

       $data=['job' => $job];

        return Inertia::render('Jobs/Show',$data);
    }

    /**
     * Show the job
     * 
     * @return void
     */
    public function index(Request $request){
        $page=$request['page'];
        $search=$request['search'];
        $onlyRemote=$request['onlyRemote'];

        
        if($onlyRemote){
            $jobs=Job:: where(function ($query) {
                $remoteSearch="remote";
                $anywhereSearch="anywhere";
                $query->where('title', 'LIKE', "%{$remoteSearch}%")
                ->orWhere('description', 'LIKE', "%{$remoteSearch}%")
                ->orWhere('location', 'LIKE', "%{$remoteSearch}%")
                ->orWhere('tags', 'LIKE', "%{$remoteSearch}%")
                ->orWhere('company', 'LIKE', "%{$remoteSearch}%")
                ->orWhere('title', 'LIKE', "%{$anywhereSearch}%")
                ->orWhere('description', 'LIKE', "%{$anywhereSearch}%")
                ->orWhere('location', 'LIKE', "%{$anywhereSearch}%")
                ->orWhere('tags', 'LIKE', "%{$anywhereSearch}%")
                ->orWhere('company', 'LIKE', "%{$anywhereSearch}%");
            })
            ->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('location', 'LIKE', "%{$search}%")
                ->orWhere('tags', 'LIKE', "%{$search}%")
                ->orWhere('company', 'LIKE', "%{$search}%");
            })
            ->orderBy('posted_date','desc')->paginate(8);
        }else{
            $jobs=Job::where('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('location', 'LIKE', "%{$search}%")
            ->orWhere('tags', 'LIKE', "%{$search}%")
            ->orWhere('company', 'LIKE', "%{$search}%")
            ->orderBy('posted_date','desc')->paginate(8);
        }
        
       
         return response()->json($jobs);
     }

     /**
     * Post a Job
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postJob(String $slug = "post-a-job")
    {
        $cacheDuration=env("CACHE_DURATION");
        $page = Cache::remember('page.slug.'.$slug, $cacheDuration, function () use($slug){
            return Page::where(['slug' => $slug, 'status' => 'ACTIVE'])->firstOrFail();
        });


        return Inertia::render('Job/Post',
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
        
        return redirect()->route('contact.show')->with('status', 'Your message has been sent');
    }
}
