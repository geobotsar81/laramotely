<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;


class StackOverflowScraperService extends Scraper{


    public function scrape(){

        $url="https://stackoverflow.com/jobs/developer-jobs-using-laravel";
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

        $nodes = $crawler->filter('.listResults .js-result');
        foreach ($nodes as $node) {
            $node = new Crawler($node);
            $tags=[];
            $company_logo="";
            $location="";
            $url="https://stackoverflow.com".$node->filter('.s-link')->first()->attr('href');
            if(strpos($url,"?") !== FALSE){
                $url=substr($url,0,strpos($url,"?"));
            }
            $title = $node->filter('.s-link')->first()->text();
            $company = $node->filter('h3 span')->first()->text();

            if(!empty($node->filter('.s-avatar--image')->count() > 0)){
                $company_logo = $node->filter('.s-avatar--image')->first()->attr("src");
                if(strpos($company_logo,"?") !== FALSE){
                    $company_logo = substr($company_logo, 0, strpos($company_logo, '?'));}
                $contents = @file_get_contents($company_logo);
                if($contents){
                Storage::disk('local')->put('public/companies/'.basename($company_logo), $contents);
                $company_logo = basename($company_logo);
                }else{$company_logo="";}
            }

            if(!empty($node->filter('.s-tag')->count() > 0)){
                $tags=$node->filter('.s-tag')->each(function ($node) use($tags){
                    if(!empty($node)){
                        $tag=$node->text();
                        array_push($tags, $tag);
                    }
                    return $tags[0];
                });
            }

            $date=$node->filter('.horizontal-list li:first-child span')->first()->text();

            if(!empty($date)){
                if(strpos($date,"yesterday") !== FALSE){
                    $date = date('Y-m-d', strtotime('-1 days', strtotime(now())));
                }
                elseif(strpos($date,"d ago") !== FALSE){
                    $date=str_replace("d ago","",$date);
                    $date = date('Y-m-d', strtotime('-'.($date*1).' days', strtotime(now())));
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
                'source' => 'stackoverflow.com'
            ];
           
            //Break from the loop if the current url already exists in the database
            if($this->jobsRepo->urlInDB($url)){
                echo "Found:"; print_r($job);
               // break;
            }else{
                if(in_array("laravel",$tags)){
                $this->jobsRepo->save($job);
                }
            }


        };

    }
}