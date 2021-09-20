<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;


class LarajobsScraperService extends Scraper{


    public function scrape(){

        $url="https://larajobs.com";
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

        $nodes = $crawler->filter('.job-link');
        foreach ($nodes as $node) {
            $node = new Crawler($node);
            $tags=[];
            $company_logo="";
            $url=$node->attr("data-url");
            $title = $node->filter('.description')->first()->text();
            $company = $node->filter('h4')->first()->text();
            $location = $node->filter('.text-xs.text-gray-600')->first()->text();

            if(!empty($node->filter('img')->count() > 0)){
                $company_logo = "https://larajobs.com/".$node->filter('img')->first()->attr("src");
                if(strpos($company_logo,"?") !== FALSE){
                $company_logo = substr($company_logo, 0, strpos($company_logo, '?'));}
                $contents = @file_get_contents($company_logo);
                if($contents){
                Storage::disk('local')->put('public/companies/'.basename($company_logo), $contents);
                $company_logo = basename($company_logo);
                }else{$company_logo="";}
            }

            $tags=$node->filter('.border-gray-400')->each(function ($node) use($tags){
                if(!empty($node)){
                    $tag=$node->text();
                    array_push($tags, $tag);
                }
                
                return $tags[0];
            });
            $doNotSave=false;
            $date = $node->filter('.flex.justify-end div:nth-child(2)')->first()->text();
            if(!empty($date)){
                if(strpos($date,"h") !== FALSE){
                    $date=str_replace("h","",$date);
                    $date = date('Y-m-d H:i:s', strtotime('-'.$date.' hours', strtotime(now())));
                }
                elseif(strpos($date,"d") !== FALSE){
                    $date=str_replace("d","",$date);
                    $date = date('Y-m-d', strtotime('-'.($date*1).' days', strtotime(now())));
                }
                elseif(strpos($date,"w") !== FALSE){
                        $date=str_replace("w","",$date);
                        $date = date('Y-m-d', strtotime('-'.($date*14).' days', strtotime(now())));
                }else{
                    $date = $node->filter('.flex.justify-end div:nth-child(1)')->first()->text();
                    if(!empty($date)){
                        if(strpos($date,"h") !== FALSE){
                            $date=str_replace("h","",$date);
                            $date = date('Y-m-d H:i:s', strtotime('-'.$date.' hours', strtotime(now())));
                        }
                        elseif(strpos($date,"d") !== FALSE){
                            $date=str_replace("d","",$date);
                            $date = date('Y-m-d', strtotime('-'.($date*1).' days', strtotime(now())));
                        }
                        elseif(strpos($date,"w") !== FALSE){
                                $date=str_replace("w","",$date);
                                $date = date('Y-m-d', strtotime('-'.($date*14).' days', strtotime(now())));
                        }else{$doNotSave=true;}
                    }else{$doNotSave=true;}
                }
            }else{$doNotSave=true;}

            $job=[
                'title' => $title,
                'url' => $url,
                'description' => "",
                'date' => $date,
                'location' => $location,
                'company' => $company,
                'company_logo' => $company_logo,
                'source' => 'larajobs.com',
                'tags' => $tags
            ];
           
            //Break from the loop if the current url already exists in the database
            if($this->jobsRepo->urlInDB($url)){
                echo "Found:$title<BR>"; 
                //break;
            }else{
                if(!$doNotSave){
                    echo "NOT Found:$title<BR>"; 
                $this->jobsRepo->save($job);
                }
            }


        };

    }
}