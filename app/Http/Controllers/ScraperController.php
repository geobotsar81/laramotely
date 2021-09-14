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
        $soScraper->scrape("https://stackoverflow.com/jobs?q=laravel&sort=p");

        $remoteokScraper=new RemoteokScraperService();
        $remoteokScraper->scrape("https://remoteok.io/api");

        $remotiveScraper=new RemotiveScraperService();
        $remotiveScraper->scrape("https://remotive.io/api/remote-jobs?search=laravel");

        $arcScraper=new ArcScraperService();
        $arcScraper->scrape("https://arc.dev/remote-jobs/laravel");

        
        
    }
}
