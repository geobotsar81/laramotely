<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpClient\HttpClient;


class RemoteokScraperService extends Scraper{


    public function scrape($url){

        $response = Http::get('https://remoteok.io/api?ref=producthunt');

        $counter=0;

        if(!empty($response->json())){

            $jobs=$response->json();
            
            foreach($jobs as $job){
            
                if($counter!=0){
                    $title=$job['position'];
                    $link=$job['url'];
                    $company=$job['company'];
                    $tags=$job['tags'];
                    $date=$job['date'];
                    $description=$job['description'];

                    if ((strpos(strtolower($title), 'laravel') !== false) || (strpos(strtolower($description), 'laravel') !== false)){
                    echo $title."</br>";
                    echo $company."</br>";
                    echo $date."</br>";
                    echo $description."</br>";
                    echo implode(",",$tags)."</br>";
                    echo $link."</br></br>";
                    }
                }
                
                $counter++;
            }
        }


    }
}