<?php
namespace App\Services;

use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class UkLaravelJobsService extends Scraper
{

    /**
     * Scrape jobs from uklaraveljobs.com
     *
     * @return void
     */
    public function scrape():void
    {
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
           
            if (!empty($node->filter('img')->count() > 0)) {
                if ($node->filter('img')->first()->attr("src") != '/images/laravel.png') {
                    $company_logo = "https://uklaraveljobs.com/".$node->filter('img')->first()->attr("src");
                    if (strpos($company_logo, "?") !== false) {
                        $company_logo = substr($company_logo, 0, strpos($company_logo, '?'));
                    }
                    $contents = @file_get_contents($company_logo);
                    if ($contents) {
                        Storage::disk('local')->put('public/companies/'.basename($company_logo), $contents);
                        $company_logo = basename($company_logo);
                    } else {
                        $company_logo="";
                    }
                } else {
                    $company_logo="";
                }
            }

            $all = $node->filter('small')->first()->text();
            $all=strip_tags($all);
            $allArray=explode('/', $all);

            $location =$allArray[2];
            $location =str_replace('Location: ', '', $location);
            $description = '';

            $date=$allArray[0];
            $date =str_replace('Added: ', '', $date);

            if (!empty($date)) {
                if (strpos($date, "hours ago") !== false) {
                    $date=str_replace(" hours ago", "", $date);
                    $date = date('Y-m-d', strtotime('-'.$date.' hours', strtotime(now())));
                } elseif (strpos($date, "days ago") !== false) {
                    $date=str_replace(" days ago", "", $date);
                    $date = date('Y-m-d', strtotime('-'.$date.' days', strtotime(now())));
                } elseif (strpos($date, "day ago") !== false) {
                    $date=str_replace(" day ago", "", $date);
                    $date = date('Y-m-d', strtotime('-1 days', strtotime(now())));
                } elseif (strpos($date, "+ weeks") !== false) {
                    $date=str_replace("+ weeks", "", $date);
                    $date = date('Y-m-d', strtotime('-'.($date*7).' days', strtotime(now())));
                } elseif (strpos($date, "months ago") !== false) {
                    $date=str_replace(" months ago", "", $date);
                    $date = date('Y-m-d', strtotime('-'.($date*31).' days', strtotime(now())));
                } elseif (strpos($date, "a month ago") !== false) {
                    $date = date('Y-m-d', strtotime('-'.(31).' days', strtotime(now())));
                } else {
                    $date=now();
                }
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
        
            $this->jobsRepo->save($job);
        };
    }
}
