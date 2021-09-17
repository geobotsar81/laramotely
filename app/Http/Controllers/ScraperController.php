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
    public function scrape($type){

        if($type == 1){
            $larajobsScraper=new LarajobsScraperService();
            $larajobsScraper->scrape("https://larajobs.com");
        }

        if($type == 2){
            $remoteokScraper=new RemoteokScraperService();
        $remoteokScraper->scrape("https://remoteok.io/api");
        }

        if($type == 3){
            $remotiveScraper=new RemotiveScraperService();
            $remotiveScraper->scrape("https://remotive.io/api/remote-jobs?search=laravel");
        }

        if($type == 4){
            $soScraper=new StackOverflowScraperService();
            $soScraper->scrape("https://stackoverflow.com/jobs?q=laravel&sort=p");
        }

        if($type == 5){
            $wwrScraper=new WwrScraperService();
            $wwrScraper->scrape("https://weworkremotely.com/remote-jobs/search?term=laravel");
        }

        if($type == 6){
            $arcScraper=new ArcScraperService();
            $arcScraper->scrape("https://arc.dev/remote-jobs/laravel");
        }
       
    }
}
