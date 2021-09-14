<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Symfony\Component\HttpClient\HttpClient;


class WwrScraperService extends Scraper{


    public function scrape($url){

        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

        $nodes = $crawler->filter('.jobs li');
        foreach ($nodes as $node) {
            $company_logo="";
            $date="";
            
            if(!empty($node)){
                if($node->filter('.title')->count() > 0){
                    
                    $title = $node->filter('.title')->first()->text();
                    $url="https://weworkremotely.com".$node->filter('a')->first()->attr("href");
                    $title = $node->filter('.title')->first()->text();
                    $company = $node->filter('.company')->first()->text();
                    $location = $node->filter('.region')->first()->text();

                    if($node->filter('time')->count() > 0){
                    $date = $node->filter('time')->first()->attr("datetime");
                    $date=date('Y-m-d',strtotime($date));
                    }else{$date=now();}

                    if(!empty($node->filter('.flag-company_logo')->count() > 0)){
                        $company_logo = $node->filter('.flag-company_logo')->first()->attr("style");
                    }

                    $job=[
                        'title' => $title,
                        'url' => $url,
                        'description' => "",
                        'date' => $date,
                        'location' => $location,
                        'company' => $company,
                        'company_logo' => $company_logo,
                        'source' => 'weworkremotely.com'
                    ];
                   
                    //Break from the loop if the current url already exists in the database
                    if($this->jobsRepo->urlInDB($url)){
                        break;
                    }else{
                        $this->jobsRepo->save($job);
                    }
                    
                   
                }
            }


        };

    }
}