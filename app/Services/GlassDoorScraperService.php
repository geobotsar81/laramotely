<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;


class GlassDoorScraperService extends Scraper{

    public function scrape(){

        $url="https://www.glassdoor.com/Job/laravel-developer-remote-jobs-SRCH_KO0,24.htm?fromAge=7";
        $client = new Client(HttpClient::create(['timeout' => 5]));
        $crawler = $client->request('GET', $url);

        $nodes = $crawler->filter('.react-job-listing');
        foreach ($nodes as $node) {
            $node = new Crawler($node);

            $tags=[];
            $logo="";
            $url=$node->filter('.jobLink')->first()->attr("href");
            $title = strip_tags($node->filter('.jobLink span')->first()->text());

            dd($url);
            $company = $node->filter('.company div:nth-child(2)')->first()->text();
            $location = $node->filter('.hyccSk')->first()->text();
            $description = $node->filter('.hidden')->first()->html();
            $date=$node->filter('.ecyiGK')->first()->text();

            if(!empty($date)){
                if(strpos($date,"days ago") !== FALSE){
                    $date=str_replace(" days ago","",$date);
                    $date = date('Y-m-d', strtotime('-'.$date.' days', strtotime(now())));
                }
                elseif(strpos($date,"+ weeks") !== FALSE){
                    $date=str_replace("+ weeks","",$date);
                    $date = date('Y-m-d', strtotime('-'.($date*7).' days', strtotime(now())));
                }elseif(strpos($date,"months ago") !== FALSE){
                    $date=str_replace(" months ago","",$date);
                    $date = date('Y-m-d', strtotime('-'.($date*31).' days', strtotime(now())));
                }elseif(strpos($date,"a month ago") !== FALSE){
                    $date = date('Y-m-d', strtotime('-'.(31).' days', strtotime(now())));
                }else{$date=now();}
            }

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
                'description' => $description,
                'date' => $date,
                'location' => $location,
                'company' => $company,
                'company_logo' => "",
                'source' => 'arc.dev',
                'tags' => $tags
            ];
        
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