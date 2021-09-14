<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpClient\HttpClient;


class RemotiveScraperService extends Scraper{


    public function scrape($url){

        $response = Http::get('https://remotive.io/api/remote-jobs?search=laravel');

        if(!empty($response->json())){

            $results=$response->json();
            $jobs=$results['jobs'];

            foreach($jobs as $job){
              
                $title=$job['title'];
                $link=$job['url'];
                $company=$job['company_name'];
                $tags=$job['category'];
                $date=$job['publication_date'];

                echo $title."</br>";
                echo $company."</br>";
                echo $date."</br>";
                echo $tags."</br>";
                echo $link."</br></br>";

            }
        }

           


    }
}