<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Repositories\JobsRepository;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    protected $jobsRepo;

    public function __construct()
    {
        $this->jobsRepo = new JobsRepository();
    }

    /**
     * Return all the jobs for the home page based on the search criteria
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getJobs(Request $request): JsonResponse
    {
        $page = $request["page"];
        $search = $request["search"];
        $onlyRemote = $request["onlyRemote"];
        $withVue = $request["withVue"];
        $withReact = $request["withReact"];
        $strictSearch = $request["strictSearch"];

        if ($onlyRemote) {
            $jobs = Job::where(function ($query) use ($strictSearch) {
                $remoteSearch = "remote";
                $anywhereSearch = "anywhere";

                $query
                    ->where("title", "LIKE", "%{$remoteSearch}%")
                    ->orWhere("location", "LIKE", "%{$remoteSearch}%")
                    ->orWhere("tags", "LIKE", "%{$remoteSearch}%")
                    ->orWhere("company", "LIKE", "%{$remoteSearch}%")
                    ->orWhere("title", "LIKE", "%{$anywhereSearch}%")
                    ->orWhere("location", "LIKE", "%{$anywhereSearch}%")
                    ->orWhere("tags", "LIKE", "%{$anywhereSearch}%")
                    ->orWhere("company", "LIKE", "%{$anywhereSearch}%");

                if (!$strictSearch) {
                    $query->orWhere("description", "LIKE", "%{$remoteSearch}%")->orWhere("description", "LIKE", "%{$anywhereSearch}%");
                }
            })
                ->where(function ($query) use ($search, $strictSearch) {
                    $query
                        ->where("title", "LIKE", "%{$search}%")
                        ->orWhere("location", "LIKE", "%{$search}%")
                        ->orWhere("tags", "LIKE", "%{$search}%")
                        ->orWhere("company", "LIKE", "%{$search}%");

                    if (!$strictSearch) {
                        $query->orWhere("description", "LIKE", "%{$search}%");
                    }
                })
                ->published()
                ->laravel()
                ->notother();

            if ($withVue) {
                $jobs = $jobs->vue(!$strictSearch);
            }
            if ($withReact) {
                $jobs = $jobs->react(!$strictSearch);
            }

            $jobs = $jobs->orderBy("posted_date", "desc")->paginate(25);
        } else {
            $jobs = Job::where("title", "LIKE", "%{$search}%")
                ->orWhere("location", "LIKE", "%{$search}%")
                ->orWhere("tags", "LIKE", "%{$search}%")
                ->orWhere("company", "LIKE", "%{$search}%")
                ->published()
                ->laravel()
                ->notother();

            if (!$strictSearch) {
                $jobs = $jobs->orWhere("description", "LIKE", "%{$search}%");
            }
            if ($withVue) {
                $jobs = $jobs->vue(!$strictSearch);
            }
            if ($withReact) {
                $jobs = $jobs->react(!$strictSearch);
            }

            $jobs = $jobs->orderBy("posted_date", "desc")->paginate(25);
        }

        return response()->json($jobs);
    }

    /**
     * Post all the jobs
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postJobs(Request $request)
    {
        $jobs = $request->json();

        if (!empty($jobs)) {
            foreach ($jobs as $job) {
                Log::info($job);
                $contents = @file_get_contents($job["company_logo"]);
                Log::info($job["company_logo"]);
                if ($contents) {
                    Log::info("Image Content");
                    $extension = "jpg";
                    $filename = $job["company"] ? Str::slug($job["company"], "-") : basename($job["company_logo"]);
                    Storage::disk("local")->put("public/companies/" . $filename . "." . $extension, $contents);
                    $job["company_logo"] = $filename . "." . $extension;
                } else {
                    Log::info("No Image Content");
                }

                $job["date"] = $job["date"] ?? now();
                $this->jobsRepo->save($job);
            }
        }

        return response(["message" => "Success"], 200);
    }
}
