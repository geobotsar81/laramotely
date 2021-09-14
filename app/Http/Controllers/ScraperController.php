<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;
use App\Services\ArcScraperService;
use App\Services\WwrScraperService;
use App\Services\LarajobsScraperService;
use App\Services\RemoteokScraperService;
use App\Services\RemotiveScraperService;
use Symfony\Component\HttpClient\HttpClient;
use App\Services\StackOverflowScraperService;

class ScraperController extends Controller
{
    /**
     * Scrape
     *
     * @return void
     */
    public function scrape(){

        $larajobsScraper=new LarajobsScraperService();
        $larajobsScraper->scrape("https://larajobs.com");

        $wwrScraper=new WwrScraperService();
        $wwrScraper->scrape("https://weworkremotely.com/remote-jobs/search?term=laravel");

        $soScraper=new StackOverflowScraperService();
        $soScraper->scrape("https://stackoverflow.com/jobs?q=laravel");

        //$remoteokScraper=new RemoteokScraperService();
        //$remoteokScraper->scrape("https://remoteok.io/api");

        //$remotiveScraper=new RemotiveScraperService();
        //$remotiveScraper->scrape("https://remotive.io/remote-laravel-jobs?live_jobs%5Bquery%5D=laravel&live_jobs%5BsortBy%5D=live_jobs_sort_by_date");

        //$arcScraper=new ArcScraperService();
        //$arcScraper->scrape("https://arc.dev/remote-jobs/laravel");

        
        
    }
}
