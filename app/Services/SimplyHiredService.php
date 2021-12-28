<?php
namespace App\Services;

use Goutte\Client;
use App\Services\Scraper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class SimplyHiredService extends Scraper
{
    /**
     * Scrape jobs from simplyhired.com
     *
     * @return void
     */
    public function scrape():void
    {
        $url="https://www.simplyhired.com/search?q=laravel&l=Remote&job=5MerubYdbK2fzdV33D7QK3wenlFexivbFjy1d9wNW-RRGovm-B1ohQ";
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

        $nodes = $crawler->filter('#job-list li');
        foreach ($nodes as $node) {
            $node = new Crawler($node);
            $tags=[];
            $company_logo="";
            $location="";
            $url="https://www.simplyhired.com".$node->filter('.jobposting-title a')->first()->attr('href');
            
            $title = $node->filter('.jobposting-title a')->first()->text();
            $company = $node->filter('.jobposting-company')->first()->text();
            $location = $node->filter('.jobposting-location')->first()->text();
            $description = $node->filter('.jobposting-snippet')->first()->text();
            
            $date=date('Y-m-d H:i:s', strtotime($node->filter('time')->first()->attr('datetime')));

            $job=[
                'title' => $title,
                'url' => $url,
                'description' =>$description,
                'date' => $date,
                'location' => $location,
                'company' => $company,
                'company_logo' => $company_logo,
                'source' => 'simplyhired.com',
                'tags' => $tags
            ];
           
            $this->jobsRepo->save($job);
        }
    }
}
