<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpClient\HttpClient;


class RemotiveScraperService extends Scraper{


    public function scrape($url){

        $response = Http::get($url);

        if(!empty($response->json())){

            $results=$response->json();
            $jobs=$results['jobs'];

            foreach($jobs as $job){
                $company_logo="";

                $title=$job['title'];
                $url=$job['url'];
                $company=$job['company_name'];
                if(!empty($job['company_logo_url'])){
                    $company_logo=$job['company_logo_url'];
                }
                $tags=$job['category'];
                $date=$job['publication_date'];
                $description=$job['description'];
                $location=$job['candidate_required_location'];

                $job=[
                    'title' => $title,
                    'url' => $url,
                    'description' => $description,
                    'date' => $date,
                    'location' => $location,
                    'company' => $company,
                    'company_logo' => $company_logo,
                    'source' => 'remotive.io'
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

           


    }
}