<?php

namespace App\Http\Controllers;

use Goutte\Client;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Services\ArcScraperService;
use App\Services\JobScraperService;
use App\Services\WwrScraperService;
use App\Services\SimplyHiredService;
use App\Services\UkLaravelJobsService;
use App\Services\LarajobsScraperService;
use App\Services\LaranewsScraperService;
use App\Services\LinkedInScraperService;
use App\Services\ReedjobsScraperService;
use App\Services\RemoteokScraperService;
use App\Services\RemotiveScraperService;
use App\Services\GlassDoorScraperService;
use App\Services\LaravelIOScraperService;
use App\Services\CleverjobsScraperService;
use App\Services\LaravelLinkScraperService;
use App\Services\ZipRecruiterScraperService;
use Symfony\Component\HttpClient\HttpClient;
use App\Services\StackOverflowScraperService;
use App\Services\WorkingNomadsScraperService;

class ScraperController extends Controller
{
    /**
     * Test the scrapers
     *
     * @return void
     */
    public function scrape($type)
    {
        if ($type == 0) {
            $larajobsScraper = new JobScraperService();
            $larajobsScraper->scrape();
        }

        if ($type == 1) {
            $larajobsScraper = new LarajobsScraperService();
            $larajobsScraper->scrape();
        }

        if ($type == 2) {
            $remoteokScraper = new RemoteokScraperService();
            $remoteokScraper->scrape();
        }

        if ($type == 3) {
            $remotiveScraper = new RemotiveScraperService();
            $remotiveScraper->scrape();
        }

        if ($type == 4) {
            //Not working
            $soScraper = new StackOverflowScraperService();
            $soScraper->scrape();
        }

        if ($type == 5) {
            $wwrScraper = new WwrScraperService();
            $wwrScraper->scrape();
        }

        if ($type == 6) {
            $arcScraper = new ArcScraperService();
            $arcScraper->scrape();
        }

        if ($type == 7) {
            $workingNomadsScraper = new WorkingNomadsScraperService();
            $workingNomadsScraper->scrape();
        }

        if ($type == 8) {
            $glassDoorScraper = new GlassDoorScraperService();
            $glassDoorScraper->scrape();
        }

        if ($type == 9) {
            $simplyHiredScraper = new SimplyHiredService();
            $simplyHiredScraper->scrape();
        }

        if ($type == 10) {
            //WIth Puppeteer
            $zipRecruiterScraper = new ZipRecruiterScraperService();
            $zipRecruiterScraper->scrape();
        }

        if ($type == 11) {
            //WIth Puppeteer
            $linkedInScraper = new LinkedInScraperService();
            $linkedInScraper->scrape();
        }

        if ($type == 12) {
            $cleverjobsScraper = new CleverjobsScraperService();
            $cleverjobsScraper->scrape();
        }

        if ($type == 14) {
            //Removed
            $uklaraveljobsScraper = new UkLaravelJobsService();
            $uklaraveljobsScraper->scrape();
        }

        if ($type == 15) {
            $reedjobsScraper = new ReedjobsScraperService();
            $reedjobsScraper->scrape();
        }

        if ($type == 16) {
            $laranewsScraper = new LaranewsScraperService();
            $laranewsScraper->scrape();
        }

        if ($type == 17) {
            $laranewsScraper = new LaravelLinkScraperService();
            $laranewsScraper->scrape();
        }

        if ($type == 18) {
            $laranewsScraper = new LaravelIOScraperService();
            $laranewsScraper->scrape();
        }
    }

    public function healthcheck()
    {
        $checks = [];

        $job = Job::where("source", "larajobs.com")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[0]["type"] = "Larajobs";
        $checks[0]["lastJobDate"] = $job->posted_date ?? "";
        $checks[0]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "remoteok.io")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[1]["type"] = "Remoteok";
        $checks[1]["lastJobDate"] = $job->posted_date ?? "";
        $checks[1]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "remotive.io")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[2]["type"] = "Remotive";
        $checks[2]["lastJobDate"] = $job->posted_date ?? "";
        $checks[2]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "weworkremotely.com")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[3]["type"] = "Weworkremotely";
        $checks[3]["lastJobDate"] = $job->posted_date ?? "";
        $checks[3]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "arc.dev")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[4]["type"] = "Arc.dev";
        $checks[4]["lastJobDate"] = $job->posted_date ?? "";
        $checks[4]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "workingnomads.co")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[5]["type"] = "Workingnomads";
        $checks[5]["lastJobDate"] = $job->posted_date ?? "";
        $checks[5]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "glassdoor.com")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[6]["type"] = "Glassdoor";
        $checks[6]["lastJobDate"] = $job->posted_date ?? "";
        $checks[6]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "simplyhired.com")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[7]["type"] = "Simplyhired.com";
        $checks[7]["lastJobDate"] = $job->posted_date ?? "";
        $checks[7]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "ziprecruiter.co.uk")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[8]["type"] = "Ziprecruiter.co.uk";
        $checks[8]["lastJobDate"] = $job->posted_date ?? "";
        $checks[8]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "cleverjobs.com")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[9]["type"] = "Cleverjobs.com";
        $checks[9]["lastJobDate"] = $job->posted_date ?? "";
        $checks[9]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "reed.co.uk")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[10]["type"] = "Reed.co.uk";
        $checks[10]["lastJobDate"] = $job->posted_date ?? "";
        $checks[10]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "linkedin.com")
            ->where("country", "USA")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[11]["type"] = "LinkedIn USA";
        $checks[11]["lastJobDate"] = $job->posted_date ?? "";
        $checks[11]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "linkedin.com")
            ->where("country", "UK")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[12]["type"] = "LinkedIn UK";
        $checks[12]["lastJobDate"] = $job->posted_date ?? "";
        $checks[12]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "linkedin.com")
            ->where("country", "DE")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[13]["type"] = "LinkedIn DE";
        $checks[13]["lastJobDate"] = $job->posted_date ?? "";
        $checks[13]["lastJob"] = $job->title ?? "";

        $job = Job::where("source", "linkedin.com")
            ->where("country", "IT")
            ->orderBy("posted_date", "desc")
            ->first();
        $checks[14]["type"] = "LinkedIn IT";
        $checks[14]["lastJobDate"] = $job->posted_date ?? "";
        $checks[14]["lastJob"] = $job->title ?? "";

        foreach ($checks as $check) {
            echo "****************";
            echo "</br>";
            echo $check["type"] ?? "";
            echo "</br> Last Date: ";
            echo $check["lastJobDate"] ? date("d-m-Y H:i:s", strtotime($check["lastJobDate"])) : "";
            echo "</br> Last Job:";
            echo "</br>";
            echo $check["lastJob"] ?? "";
            echo "</br>";
            echo "</br>";
        }
    }
}
