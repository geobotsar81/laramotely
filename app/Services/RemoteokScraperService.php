<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpClient\HttpClient;


class RemoteokScraperService extends Scraper{


    public function scrape($url){

        $response = Http::get($url);

        $counter=0;

        if(!empty($response->json())){

            $jobs=$response->json();
            
            foreach($jobs as $job){
            
                if($counter!=0){
                    $title=$job['position'];
                    $url=$job['url'];
                    $company=$job['company'];
                    $tags=$job['tags'];
                    $date=$job['date'];
                    $description=$job['description'];
                    $company_logo=$job['company_logo'];
                    $location=$job['location'];

                    if ((strpos(strtolower($title), 'laravel') !== false) || (strpos(strtolower($description), 'laravel') !== false)){

                        if(!empty($company_logo)){
                        $contents = file_get_contents($company_logo);
                        $contents = file_get_contents($company_logo);
                        Storage::disk('local')->put('public/companies/'.basename($company_logo), $contents);
                        $company_logo = basename($company_logo);
                        }

                        $job=[
                            'title' => $title,
                            'url' => $url,
                            'description' => $description,
                            'date' => $date,
                            'location' => $location,
                            'company' => $company,
                            'company_logo' => $company_logo,
                            'source' => 'remoteok.com'
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
                
                $counter++;
            }
        }


    }
}