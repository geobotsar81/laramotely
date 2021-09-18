<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;
use App\Services\ArcScraperService;
use App\Services\JobScraperService;
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

        if($type == 0){
            $larajobsScraper=new JobScraperService();
            $larajobsScraper->scrape();
        }

        if($type == 1){
            $larajobsScraper=new LarajobsScraperService();
            $larajobsScraper->scrape();
        }

        if($type == 2){
            $remoteokScraper=new RemoteokScraperService();
            $remoteokScraper->scrape();
        }

        if($type == 3){
            $remotiveScraper=new RemotiveScraperService();
            $remotiveScraper->scrape();
        }

        if($type == 4){
            $soScraper=new StackOverflowScraperService();
            //$soScraper->scrape("https://stackoverflow.com/jobs?q=laravel&sort=p");
            $soScraper->scrape();
        }

        if($type == 5){
            $wwrScraper=new WwrScraperService();
            $wwrScraper->scrape();
        }

        if($type == 6){
            $arcScraper=new ArcScraperService();
            $arcScraper->scrape();
        }
       
    }
}
