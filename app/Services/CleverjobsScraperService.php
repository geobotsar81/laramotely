<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;


class CleverjobsScraperService extends Scraper{


    public function scrape(){

        $url="https://cleverjobs.net/tags/laravel";
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

        $nodes = $crawler->filter('#main .column.is-four-fifths-fullhd');

        
        foreach ($nodes as $node) {
            $node = new Crawler($node);
           
            $tags=[];
            $company_logo="";
            $location="";

            if(!empty($node->filter('h4')->count() > 0)){
                $url=$node->filter('a')->first()->attr('href');
                if(strpos($url,"?") !== FALSE){
                    $url=substr($url,0,strpos($url,"?"));
                }
                $title = $node->filter('h4')->first()->text();
                $title=strip_tags($title);
                $company = $node->filter('.tags .tag:nth-child(2)')->first()->text();
                $company=strip_tags($company);
                
                $location = $node->filter('.tags .tag:nth-last-child(2)')->first()->text();
                $location=strip_tags($location);

                $date=$node->filter('.tags .tag:nth-child(1)')->first()->text();

                if(!empty($date)){
                    $date=strip_tags($date);
                    
                    if(strpos($date,"hours ago") !== FALSE){
                        $date=str_replace(" hours ago","",$date);
                        $date = date('Y-m-d H:i:s', strtotime('-'.$date.' hours', strtotime(now())));
                    }
                    elseif(strpos($date,"days ago") !== FALSE){
                        $date=str_replace(" days ago","",$date);
                        $date = date('Y-m-d', strtotime('-'.$date.' days', strtotime(now())));
                    }
                    elseif(strpos($date,"week ago") !== FALSE){
                        $date=str_replace(" week ago","",$date);
                        $date = date('Y-m-d', strtotime('-7 days', strtotime(now())));
                    }
                    elseif(strpos($date,"weeks ago") !== FALSE){
                        $date=str_replace(" weeks ago","",$date);
                        $date = date('Y-m-d', strtotime('-'.($date*7).' days', strtotime(now())));
                    }elseif(strpos($date,"months ago") !== FALSE){
                        $date=str_replace(" months ago","",$date);
                        $date = date('Y-m-d', strtotime('-'.($date*31).' days', strtotime(now())));
                    }elseif(strpos($date,"a month ago") !== FALSE){
                        $date = date('Y-m-d', strtotime('-'.(31).' days', strtotime(now())));
                    }else{$date=now();}
                }

                //$location = $node->filter('.horizontal-list li:nth-child(2)')->first()->text();

                $job=[
                    'title' => $title,
                    'url' => $url,
                    'description' => "",
                    'date' => $date,
                    'location' => $location,
                    'company' => $company,
                    'company_logo' => $company_logo,
                    'source' => 'stackoverflow.com',
                    'tags' => $tags
                ];
            
                //print_r($job);
                //echo "<br><br>----------<br><br>";

                    $this->jobsRepo->save($job);
            }

        }

    }
}