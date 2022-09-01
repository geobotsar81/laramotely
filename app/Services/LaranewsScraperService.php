<?php
namespace App\Services;

use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class LaranewsScraperService extends Scraper
{
    /**
     * Scrape jobs from larajobs.com
     *
     * @return void
     */
    public function scrape(): void
    {
        $url = "https://laravel-news.com/blog";
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
                $url = "https://laravel-news.com/" . $node->filter("a")->attr("href");
            }

            if (!empty($node->filter("h3 span")->count() > 0)) {
                $title = $node
                    ->filter("h3 span")
                    ->first()
                    ->text();
            } elseif (!empty($node->filter("h4 span")->count() > 0)) {
                $title = $node
                    ->filter("h4 span")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".flex.items-center.mb-1 span")->count() > 0)) {
                $category = $node
                    ->filter(".flex.items-center.mb-1 span")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".font-mono.text-xs.font-normal.text-gray-400")->count() > 0)) {
                $date = $node
                    ->filter(".font-mono.text-xs.font-normal.text-gray-400")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".font-display.mt-2.text-sm.text-gray-400")->count() > 0)) {
                $description = $node
                    ->filter(".font-display.mt-2.text-sm.text-gray-400")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter("img")->count() > 0)) {
                $image = $node
                    ->filter("img")
                    ->first()
                    ->attr("src");

                if (strpos($image, "?") !== false) {
                    $image = substr($image, 0, strpos($image, "?"));
                }

                $contents = @file_get_contents($image);
                if ($contents) {
                    $filename = basename($image);
                    Storage::disk("local")->put("public/news/" . $filename, $contents);
                    $image = $filename;
                } else {
                    $image = "";
                }
            }

            $news = [
                "title" => $title,
                "url" => $url,
                "description" => $description,
                "category" => $category,
                "date" => date("Y-m-d H:i:s", strtotime($date)),
                "image" => $image,
                "source" => "laravel-news.com",
            ];

            if (!empty($title) && $category != "Sponsor") {
                $this->articlesRepo->save($news);
            }
        }
    }
}
