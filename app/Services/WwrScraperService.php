<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;


class WwrScraperService extends Scraper{


    public function scrape($url){

        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

        $nodes = $crawler->filter('.jobs li');
        foreach ($nodes as $node) {
            $node = new Crawler($node);
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
                        $contents = file_get_contents($company_logo);
                        Storage::disk('local')->put('public/companies/'.basename($company_logo), $contents);
                        $company_logo = basename($company_logo);
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
                        echo "Found:"; print_r($job);
                        break;
                    }else{
                        $this->jobsRepo->save($job);
                    }
                    
                   
                }
            }


        };

    }
}