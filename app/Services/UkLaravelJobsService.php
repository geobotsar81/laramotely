<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;


class UkLaravelJobsService extends Scraper{

    public function scrape(){

        $url="https://uklaraveljobs.com/";
        $client = new Client(HttpClient::create(['timeout' => 5]));
        $crawler = $client->request('GET', $url);

        $nodes = $crawler->filter('main .row.p-3.bg-1 ');
        foreach ($nodes as $node) {
            $node = new Crawler($node);

            $tags=[];
            $logo="";
            $url=$node->filter('a')->first()->attr("href");
            $title = $node->filter('.col-sm-12.col-md-7.text-center.text-md-left a')->first()->text();
            $company_logo = $node->filter('img')->first()->attr("src");

            $all = $node->filter('small')->first()->text();
            $all=strip_tags($all);
            $allArray=explode('/',$all);

            $location =$allArray[2];
            $location =str_replace('Location: ','',$location);

            //$location = $node->filter('.hyccSk')->first()->text();
            $description = '';

            $date=$allArray[0];
            $date =str_replace('Added: ','',$date);

            if(!empty($date)){
                if(strpos($date,"hours ago") !== FALSE){
                    $date=str_replace(" hours ago","",$date);
                    $date = date('Y-m-d', strtotime('-'.$date.' hours', strtotime(now())));
                }
                elseif(strpos($date,"days ago") !== FALSE){
                    $date=str_replace(" days ago","",$date);
                    $date = date('Y-m-d', strtotime('-'.$date.' days', strtotime(now())));
                }
                elseif(strpos($date,"day ago") !== FALSE){
                    $date=str_replace(" day ago","",$date);
                    $date = date('Y-m-d', strtotime('-1 days', strtotime(now())));
                }elseif(strpos($date,"+ weeks") !== FALSE){
                    $date=str_replace("+ weeks","",$date);
                    $date = date('Y-m-d', strtotime('-'.($date*7).' days', strtotime(now())));
                }elseif(strpos($date,"months ago") !== FALSE){
                    $date=str_replace(" months ago","",$date);
                    $date = date('Y-m-d', strtotime('-'.($date*31).' days', strtotime(now())));
                }elseif(strpos($date,"a month ago") !== FALSE){
                    $date = date('Y-m-d', strtotime('-'.(31).' days', strtotime(now())));
                }else{$date=now();}
            }



            $job=[
                'title' => $title,
                'url' => $url,
                'description' => $description,
                'date' => $date,
                'location' => $location,
                'company' => '',
                'company_logo' => $company_logo,
                'source' => 'uklaraveljobs.com',
                'tags' => ''
            ];
        
           
            //echo $title.", ".$url.", ".$date.", ".$location.", ".$company_logo;
            //echo "<br>--------------------<br>";

                $this->jobsRepo->save($job);
          


        };

    }
}