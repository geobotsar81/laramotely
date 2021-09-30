<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;


class LinkedInScraperService extends Scraper{


    public function scrape(){

        $url="https://www.linkedin.com/jobs/remote-laravel-jobs";
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);
        

        $nodes = $crawler->filter('.base-card');

        foreach ($nodes as $node) {
            $node = new Crawler($node);
            $company_logo="";
            $date="";
            $tags="";
            $company="";
            $location="";
            
            
            if(!empty($node)){
                if($node->filter('.base-search-card__title')->count() > 0){

                    $title = $node->filter('.base-search-card__title')->first()->text();
                    $url=$node->filter('.base-card__full-link')->first()->attr("href");
                    if(strpos($url,"?") !== FALSE){
                        $url=substr($url,0,strpos($url,"?"));
                    }

                    if($node->filter('time')->count() > 0){
                    $company = $node->filter('.hidden-nested-link')->first()->text();
                    }
                    if($node->filter('time')->count() > 0){
                    $location = $node->filter('.job-search-card__location')->first()->text();
                    }

                    if($node->filter('time')->count() > 0){
                    $date = $node->filter('time')->first()->attr("datetime");
                    $date=date('Y-m-d',strtotime($date));
                    }else{$date=now();}

                    if(!empty($node->filter('.artdeco-entity-image')->count() > 0)){
                        $company_logo = $node->filter('.artdeco-entity-image')->first()->attr("data-ghost-url");
                        //echo $company_logo."<br>";
                    }

                    $job=[
                        'title' => $title,
                        'url' => $url,
                        'description' => "",
                        'date' => $date,
                        'location' => $location,
                        'company' => $company,
                        'company_logo' => $company_logo,
                        'source' => 'linkedin.com',
                        'tags' => $tags
                    ];

                    if(strpos(strtolower($title),"laravel") !== FALSE){
                        //Break from the loop if the current url already exists in the database
                     
                                $this->jobsRepo->save($job);
                         
                    }
                    
                   
                }
            }


        };

    }
}