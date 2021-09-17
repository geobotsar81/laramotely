<?php
namespace App\Services;
use Goutte\Client;
use App\Services\Scraper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;


class StackOverflowScraperService extends Scraper{


    public function scrape($url){

        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

        $nodes = $crawler->filter('.listResults .js-result');
        foreach ($nodes as $node) {
            $node = new Crawler($node);
            $tags=[];
            $company_logo="";
            $url="https://stackoverflow.com".$node->filter('.s-link')->first()->attr('href');
            $title = $node->filter('.s-link')->first()->text();
            $company = $node->filter('h3 span')->first()->text();

            if(!empty($node->filter('.s-avatar--image')->count() > 0)){
                $company_logo = $node->filter('.s-avatar--image')->first()->attr("src");
                $contents = file_get_contents($company_logo);
                Storage::disk('local')->put('public/companies/'.basename($company_logo), $contents);
                $company_logo = basename($company_logo);
            }

            $tags=$node->filter('.s-tag')->each(function ($node) use($tags){
                if(!empty($node)){
                    $tag=$node->text();
                    array_push($tags, $tag);
                }
                return $tags[0];
            });

            $location = $node->filter('.horizontal-list li:nth-child(2)')->first()->text();

            $job=[
                'title' => $title,
                'url' => $url,
                'description' => "",
                'date' => now(),
                'location' => $location,
                'company' => $company,
                'company_logo' => $company_logo,
                'source' => 'stackoverflow.com'
            ];
           
            //Break from the loop if the current url already exists in the database
            if($this->jobsRepo->urlInDB($url)){
                echo "Found:"; print_r($job);
                break;
            }else{
                $this->jobsRepo->save($job);
            }


        };

    }
}