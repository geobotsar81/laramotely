<?php
namespace App\Services;
use GuzzleHttp\Client;
use App\Services\Scraper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;


class ZipRecruiterScraperService extends Scraper{

    public function scrape(){

        $url="https://www.ziprecruiter.co.uk/Jobs/Laravel";

        //$client = new Client(HttpClient::create(['timeout' => 60]));
        //$client->setServerParameter('HTTP_USER_AGENT', "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");
        //$crawler = $client->request('GET', $url);

        $client = new \GuzzleHttp\Client();
        $crawler = $client->request('GET', $url);  
        dd( $crawler->getStatusCode()); // 200

        $nodes = $crawler->filter('.job-listing');
        dd($nodes);
        foreach ($nodes as $node) {
            $node = new Crawler($node);

            $tags=[];
            $logo="";
            $url=$node->filter('.jobList-title')->first()->attr("href");
            $title = $node->filter('.jobList-title strong')->first()->text();
            $company = strip_tags($node->filter('.jobList-introMeta li:nth-child(1)')->first()->text());
            $location = strip_tags($node->filter('.jobList-introMeta li:nth-child(2)')->first()->text());
            $description = $node->filter('.jobList-description')->first()->html();
            $date=$node->filter('.jobList-date')->first()->text();

            if(!empty($date)){
                $date=date('Y-m-d',strtotime($date.' 2021'));
            }

            $tags='';


            $job=[
                'title' => $title,
                'url' => $url,
                'description' => $description,
                'date' => $date,
                'location' => $location,
                'company' => $company,
                'company_logo' => "",
                'source' => 'https://www.ziprecruiter.co.uk/',
                'tags' => $tags
            ];
        
            //print_r($job);

            //echo "<br><br>-----------------------------------<br><br>";


            //Break from the loop if the current url already exists in the database
            if($this->jobsRepo->urlInDB($url)){
                echo "Found:"; print_r($job);
                //break;
            }else{
                $this->jobsRepo->save($job);
            } 


        };

    }
}