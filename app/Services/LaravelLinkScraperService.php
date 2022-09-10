<?php
namespace App\Services;

use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class LaravelLinkScraperService extends Scraper
{
    /**
     * Scrape jobs from larajobs.com
     *
     * @return void
     */
    public function scrape(): void
    {
        $url = "https://laravel-news.com/links";
        $client = new Client(HttpClient::create(["timeout" => 60]));
        $crawler = $client->request("GET", $url);

        $nodes = $crawler->filter("main li");

        foreach ($nodes as $node) {
            $node = new Crawler($node);
            $image = "";
            $url = "";
            $title = "";
            $date = "";
            $description = "";
            $category = "";

            if (!empty($node->filter("a")->count() > 0)) {
                $url = $node->filter("a")->attr("href");
            }

            if (!empty($node->filter(".link-underline")->count() > 0)) {
                $title = $node
                    ->filter(".link-underline")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".rounded-full")->count() > 0)) {
                $category = $node
                    ->filter(".rounded-full")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".font-mono.text-xs.text-gray-500")->count() > 0)) {
                $date = $node
                    ->filter(".font-mono.text-xs.text-gray-500")
                    ->first()
                    ->text();

                if (!empty($date)) {
                    if (strpos($date, "day ago") !== false) {
                        $date = str_replace(" day ago", "", $date);
                        $date = date("Y-m-d", strtotime("-" . $date . " days", strtotime(now())));
                    } elseif (strpos($date, "days ago") !== false) {
                        $date = str_replace(" days ago", "", $date);
                        $date = date("Y-m-d", strtotime("-" . $date . " days", strtotime(now())));
                    } elseif (strpos($date, " week ago") !== false) {
                        $date = str_replace(" week ago", "", $date);
                        $date = date("Y-m-d", strtotime("-" . $date * 7 . " days", strtotime(now())));
                    } elseif (strpos($date, " weeks ago") !== false) {
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
            }

            $news = [
                "title" => $title,
                "url" => $url,
                "description" => "",
                "category" => $category,
                "date" => date("Y-m-d H:i:s", strtotime($date)),
                "image" => "",
                "source" => "laravel-news.com",
            ];

            if (!empty($title) && $category != "Sponsor") {
                $this->articlesRepo->save($news);
            }
        }
    }
}
