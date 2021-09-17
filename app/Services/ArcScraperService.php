<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;


class ArcScraperService extends Scraper{

    public function scrape($url){

        $client = new Client(HttpClient::create(['timeout' => 5]));
        $crawler = $client->request('GET', $url);

        $nodes = $crawler->filter('.card-container');
        foreach ($nodes as $node) {
            $node = new Crawler($node);

            $tags=[];
            $logo="";
            $url="https://arc.dev".$node->filter('h2 a')->first()->attr("href");
            $title = $node->filter('h2 a')->first()->text();
            $company = $node->filter('.company div:nth-child(2)')->first()->text();
            $location = $node->filter('.hyccSk')->first()->text();

            $tags=$node->filter('.tech-stack')->each(function ($node) use($tags){
                if(!empty($node)){
                    $tag=$node->text();
                    array_push($tags, $tag);
                }
                
                return $tags[0];
            });


            $job=[
                'title' => $title,
                'url' => $url,
                'description' => "",
                'date' => now(),
                'location' => $location,
                'company' => $company,
                'company_logo' => "",
                'source' => 'arc.dev'
            ];
        
            //Break from the loop if the current url already exists in the database
            if($this->jobsRepo->urlInDB($url)){
                echo "Found:"; print_r($job);
                break;
            }else{
                $this->jobsRepo->save($job);
            }   


        };

    }
}