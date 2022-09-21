<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Job;
use App\Mail\JobMail;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Repositories\JobsRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    protected $jobsRepo;

    public function __construct()
    {
        $this->jobsRepo = new JobsRepository();
    }

    public function updateJobViews(Request $request)
    {
        $jobId = $request["jobId"];
        $this->jobsRepo->updateViews($jobId);
        return response(["message" => "Success"], 200);
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
        $inCountries = $request["inCountries"];
        $sortBy = $request["sortBy"];

        $jobs = Job::notother()
            ->published()
            ->laravel(!$strictSearch)
            ->where(function ($query) use ($search) {
                $query
                    ->where("title", "LIKE", "%{$search}%")
                    ->orWhere("description", "LIKE", "%{$search}%")
                    ->orWhere("location", "LIKE", "%{$search}%")
                    ->orWhere("tags", "LIKE", "%{$search}%")
                    ->orWhere("company", "LIKE", "%{$search}%");
            });

        if (!$strictSearch) {
            $jobs = $jobs->orWhere("description", "LIKE", "%{$search}%");
        }
        if ($withVue) {
            $jobs = $jobs->vue(!$strictSearch);
        }
        if ($withReact) {
            $jobs = $jobs->react(!$strictSearch);
        }

        if ($onlyRemote) {
            $jobs = $jobs->remote(!$strictSearch);
        }

        if (!empty($inCountries)) {
            $countriesArray = explode(",", $inCountries);
            $jobs = $jobs->inCountries($countriesArray);
        }

        if ($sortBy == "popular") {
            $jobs = $jobs->orderBy("views", "desc");
        } else {
            $jobs = $jobs->orderBy("posted_date", "desc");
        }

        $jobs = $jobs->paginate(25);

        return response()->json($jobs);
    }

    public function getFavourites(Request $request): JsonResponse
    {
        $favourites = $request["jobIds"];

        $jobs = Job::whereIn("id", $favourites)->paginate(25);
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
        try {
            $jobs = $request->json();

            //Log::info("Getting jobs for API");

            if (!empty($jobs)) {
                foreach ($jobs as $job) {
                    //Log::info($job);
                    $contents = @file_get_contents($job["company_logo"]);

                    if ($contents) {
                        $extension = "jpg";

                        if ($job["source"] == "glassdoor.com") {
                            $extension = "png";
                        }
                        $filename = $job["company"] ? Str::slug($job["company"], "-") : basename($job["company_logo"]);
                        Storage::disk("local")->put("public/companies/" . $filename . "." . $extension, $contents);
                        $job["company_logo"] = $filename . "." . $extension;
                    }

                    if ($job["source"] == "glassdoor.com") {
                        $job["date"] = $this->getDate($job["date"]);
                    } else {
                        $job["date"] = $job["date"] ?? now();
                    }

                    Log::info($job);

                    $this->jobsRepo->save($job);
                }
            }

            return response(["message" => "Success"], 200);
        } catch (Exception $e) {
            return response(["message" => $e->getMessage()], 404);
        }
    }

    public function getDate($date)
    {
        if (strpos($date, "h") !== false) {
            $date = str_replace("h", "", $date);
            $date = date("Y-m-d H:i:s", strtotime("-" . $date . " hours", strtotime(now())));
        } elseif (strpos($date, "d") !== false) {
            $date = str_replace("d", "", $date);
            $date = date("Y-m-d", strtotime("-" . $date * 1 . " days", strtotime(now())));
        } elseif (strpos($date, "w") !== false) {
            $date = str_replace("w", "", $date);
            $date = date("Y-m-d", strtotime("-" . $date * 14 . " days", strtotime(now())));
        } elseif (strpos($date, "mos") !== false) {
            $date = str_replace("mos", "", $date);
            $date = date("Y-m-d", strtotime("-" . $date * 31 . " days", strtotime(now())));
        } elseif (strpos($date, "mo") !== false) {
            $date = str_replace("mo", "", $date);
            $date = date("Y-m-d", strtotime("-" . 31 . " days", strtotime(now())));
        } else {
            $date = now();
        }

        return $date;
    }

    /**
     * Return all the articles for the articles page based on the search criteria
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getArticles(Request $request): JsonResponse
    {
        $page = $request["page"];
        $search = $request->get("search", "");
        $category = $request->get("category", "");

        $articles = Article::where(function ($query) use ($search) {
            $query
                ->where("title", "LIKE", "%{$search}%")
                ->orWhere("category", "LIKE", "%{$search}%")
                ->orWhere("description", "LIKE", "%{$search}%");
        });

        if (!empty($category)) {
            if ($category != "all") {
                $articles = $articles->where("category", $category);
            }
        }

        $articles = $articles->orderBy("posted_date", "desc")->paginate(25);

        return response()->json($articles);
    }

    /**
     * Post a job through the API
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postJob(Request $request): Response
    {
        $validated = $request->validate([
            "jobTitle" => "required",
            "jobEmail" => "email:rfc,dns",
            "jobCompany" => "required",
            "jobUrl" => "required",
            "jobTags" => "required",
            "jobDescription" => "required",
            "jobLocation" => "required",
        ]);

        $job = [
            "subject" => "Post a Job",
            "jobTitle" => $request["jobTitle"],
            "jobEmail" => $request["jobEmail"],
            "jobCompany" => $request["jobCompany"],
            "jobUrl" => $request["jobUrl"],
            "jobTags" => $request["jobTags"],
            "jobDescription" => $request["jobDescription"],
            "jobLocation" => $request["jobLocation"],
        ];

        Mail::to("info@laramotely.com")->send(new JobMail($job));

        return response(["message" => "Your job opening was submited successfully and will be reviewed shortly."], 200);
    }

    /**
     * Validate the contact form and send the contact email
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendMail(Request $request): Response
    {
        $validated = $request->validate([
            "contactName" => "required",
            "contactEmail" => "email:rfc,dns",
            "contactMessage" => "required",
        ]);

        $contact = [
            "fullname" => $request["contactName"],
            "email" => $request["contactEmail"],
            "subject" => "Contact Form email",
            "message" => $request["contactMessage"],
        ];

        Mail::to("info@laramotely.com")->send(new ContactFormMail($contact));
        return response(["message" => "Your message has been sent."], 200);
    }
}
