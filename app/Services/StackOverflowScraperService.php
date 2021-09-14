<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Symfony\Component\HttpClient\HttpClient;


class StackOverflowScraperService extends Scraper{


    public function scrape($url){

        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

        $crawler->filter('.listResults .js-result')->each(function ($node) {
            $tags=[];
            $logo="";
            $link="https://stackoverflow.com".$node->filter('.s-link')->first()->attr('href');
            $title = $node->filter('.s-link')->first()->text();
            $company = $node->filter('h3 span')->first()->text();

            if(!empty($node->filter('.s-avatar--image')->count() > 0)){
                $logo = $node->filter('.s-avatar--image')->first()->attr("src");
            }

            $tags=$node->filter('.s-tag')->each(function ($node) use($tags){
                if(!empty($node)){
                    $tag=$node->text();
                    array_push($tags, $tag);
                }
                
                
                return $tags[0];
            });

            echo $title."</br>";
            echo $company."</br>";
            echo $logo."</br>";
            echo implode(",",$tags)."</br>";
            echo $link."</br></br>";


        });

    }
}