<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Symfony\Component\HttpClient\HttpClient;


class ArcScraperService extends Scraper{

    public function scrape($url){

        $client = new Client(HttpClient::create(['timeout' => 5]));
        $crawler = $client->request('GET', $url);

        $crawler->filter('.card-container')->each(function ($node) {
            $tags=[];
            $logo="";
            $link="https://arc.dev".$node->filter('h2 a')->first()->attr("href");
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

            echo $title."</br>";
            echo $company."</br>";
            echo $location."</br>";
            echo implode(",",$tags)."</br>";
            echo $link."</br></br>";


        });

    }
}