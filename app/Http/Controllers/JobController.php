<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Inertia\Inertia;
use App\Mail\JobMail;
use Inertia\Response;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class JobController extends Controller
{

    /**
     * Display the selected job
     *
     * @param integer $id
     * @return Response
     */
    public function show(int $id):Response
    {
        $number=($id%5);
        $ogImage="ogimage$number.jpg";

        $job=Job::where('id', $id)->firstOrFail();
       
        $otherJobs=Job::where('id', '!=', $id)->published()->orderBy('posted_date', 'DESC')->take(5)->get();

        $data=['job' => $job];
        $data['otherJobs']= $otherJobs;

        $tagsString="";

        $tags=$job->tags;
        if (!empty($tags) && $tags!='""' && $tags!='[]') {
            $tags=json_decode($tags);
            if (is_array($tags)) {
                $tagsString=" - ".implode(",", $tags);
            } else {
                $tagsString=" - ".$tags;
            }
        } else {
            $tagsString="";
        }

        if (!empty($job->company)) {
            $title=$job->title.' at '.$job->company.$tagsString;
            $description=$job->company." is looking for a ".$job->title.". Location: ".$job->location.$tagsString.". Read more at ".$job->url;
        } else {
            $title=$job->title.$tagsString;
            $description=$job->title." needed. Location: ".$job->location.$tagsString.". Read more at ".$job->url;
        }
        $data['meta_title']=$title;
        $data['meta_description']=$description;
        return Inertia::render('Jobs/Show', $data)->withViewData(['ogImage' => $ogImage,'title' => $title,'description' => $description,'url' => route('job.show', $job->id)]);
    }

    /**
     * Return all the jobs for the home page based on the search criteria
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request):JsonResponse
    {
        $page=$request['page'];
        $search=$request['search'];
        $onlyRemote=$request['onlyRemote'];

        
        if ($onlyRemote) {
            $jobs=Job::where(function ($query) {
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
            ->published()
            ->laravel()
            ->notother()
            ->orderBy('posted_date', 'desc')->paginate(8);
        } else {
            $jobs=Job::where('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('location', 'LIKE', "%{$search}%")
            ->orWhere('tags', 'LIKE', "%{$search}%")
            ->orWhere('company', 'LIKE', "%{$search}%")
            ->published()
            ->laravel()
            ->notother()
            ->orderBy('posted_date', 'desc')->paginate(8);
        }
        
       
        return response()->json($jobs);
    }

    /**
     * Display the Post a Job page
     *
     * @param string $slug
     * @return Response
     */
    public function postJob(String $slug = "post-a-job"):Response
    {
        $cacheDuration=env("CACHE_DURATION");
        $page = Cache::remember('page.slug.'.$slug, $cacheDuration, function () use ($slug) {
            return Page::where(['slug' => $slug, 'status' => 'ACTIVE'])->firstOrFail();
        });

        return Inertia::render(
            'Jobs/Post',
            [
            "page" => $page,
        ]
        )
        ->withViewData(['title' => $page->title,'description' => $page->meta_description,'url' => route('job.post')]);
    }

    /**
     * Submit a job from the Post a Job page
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendJob(Request $request):RedirectResponse
    {
        $validated = $request->validate([
            'jobTitle' => 'required',
            'jobEmail' => 'email:rfc,dns',
            'jobCompany' => 'required',
            'jobUrl' => 'required',
            'jobTags' => 'required',
            'jobDescription' => 'required',
            'jobLocation' => 'required',
            'honeypot' => 'present|max:0',
        ]);

        $job = [
            'subject' => "Post a Job",
            'jobTitle' => $request['jobTitle'],
            'jobEmail' => $request['jobEmail'],
            'jobCompany' => $request['jobCompany'],
            'jobUrl' => $request['jobUrl'],
            'jobTags' => $request['jobTags'],
            'jobDescription' => $request['jobDescription'],
            'jobLocation' => $request['jobLocation'],
        ];

    
        Mail::to('info@laramotely.com')->send(new JobMail($job));
        return redirect()->route('job.post')->with('status', 'Your job has been submited!');
    }
}
