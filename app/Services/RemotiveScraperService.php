<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpClient\HttpClient;


class RemotiveScraperService extends Scraper{


    public function scrape(){

        $url="https://remotive.io/api/remote-jobs?search=laravel";
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
                    if(strpos($company_logo,"?") !== FALSE){
                        $company_logo = substr($company_logo, 0, strpos($company_logo, '?'));}
                        $contents = @file_get_contents($company_logo);
                        if($contents){
                        $company_logo = basename($company_logo);
                        $company_logo=str_replace("logo","logo".strtotime(now()),$company_logo);
                        echo $company_logo."<br><br>";
                        Storage::disk('local')->put('public/companies/'.$company_logo, $contents);
                        
                        }else{$company_logo="";}
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