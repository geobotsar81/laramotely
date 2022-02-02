<?php
namespace App\Services;

use Goutte\Client;
use App\Services\Scraper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class CleverjobsScraperService extends Scraper
{
    /**
     * Scrape jobs from cleverjobs.net
     *
     * @return void
     */
    public function scrape(): void
    {
        $url = "https://cleverjobs.net/tags/laravel";
        $client = new Client(HttpClient::create(["timeout" => 60]));
        $crawler = $client->request("GET", $url);
        $nodes = $crawler->filter("#main .column.is-four-fifths-fullhd");

        foreach ($nodes as $node) {
            $node = new Crawler($node);

            $tags = [];
            $company_logo = "";
            $location = "";

            if (!empty($node->filter("h4")->count() > 0)) {
                $url = $node
                    ->filter("a")
                    ->first()
                    ->attr("href");
                if (strpos($url, "?") !== false) {
                    $url = substr($url, 0, strpos($url, "?"));
                }
                $title = $node
                    ->filter("h4")
                    ->first()
                    ->text();
                $title = strip_tags($title);
                $company = $node
                    ->filter(".tags .tag:nth-child(2)")
                    ->first()
                    ->text();
                $company = strip_tags($company);

                $location = $node
                    ->filter(".tags .tag:nth-last-child(2)")
                    ->first()
                    ->text();
                $location = strip_tags($location);

                $date = $node
                    ->filter(".tags .tag:nth-child(1)")
                    ->first()
                    ->text();

                if (!empty($date)) {
                    $date = strip_tags($date);

                    if (strpos($date, "hours ago") !== false) {
                        $date = str_replace(" hours ago", "", $date);
                        $date = date("Y-m-d H:i:s", strtotime("-" . $date . " hours", strtotime(now())));
                    } elseif (strpos($date, "days ago") !== false) {
                        $date = str_replace(" days ago", "", $date);
                        $date = date("Y-m-d", strtotime("-" . $date . " days", strtotime(now())));
                    } elseif (strpos($date, "week ago") !== false) {
                        $date = str_replace(" week ago", "", $date);
                        $date = date("Y-m-d", strtotime("-7 days", strtotime(now())));
                    } elseif (strpos($date, "weeks ago") !== false) {
                        $date = str_replace(" weeks ago", "", $date);
                        $date = date("Y-m-d", strtotime("-" . $date * 7 . " days", strtotime(now())));
                    } elseif (strpos($date, "months ago") !== false) {
                        $date = str_replace(" months ago", "", $date);
                        $date = date("Y-m-d", strtotime("-" . $date * 31 . " days", strtotime(now())));
                    } elseif (strpos($date, "a month ago") !== false) {
                        $date = date("Y-m-d", strtotime("-" . 31 . " days", strtotime(now())));
                    } else {
                        $date = now();
                    }
                }

                $job = [
                    "title" => $title,
                    "url" => $url,
                    "description" => "",
                    "date" => $date,
                    "location" => $location,
                    "company" => $company,
                    "company_logo" => $company_logo,
                    "source" => "cleverjobs.com",
                    "tags" => $tags,
                ];

                $this->jobsRepo->save($job);
            }
        }
    }
}
