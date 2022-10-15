<?php
namespace App\Services;

use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class LaravelIOScraperService extends Scraper
{
    /**
     * Scrape jobs from larajobs.com
     *
     * @return void
     */
    public function scrape(): void
    {
        $url = "https://laravel.io/articles";
        $client = new Client(HttpClient::create(["timeout" => 60]));
        $crawler = $client->request("GET", $url);

        $nodes = $crawler->filter("section.mt-8.mb-5 .h-full.rounded-lg");

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

            if (!empty($node->filter("h3")->count() > 0)) {
                $title = $node
                    ->filter("h3")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".flex.flex-wrap.items-center.space-x-1.text-sm .text-gray-700")->count() > 0)) {
                $date = $node
                    ->filter(".flex.flex-wrap.items-center.space-x-1.text-sm .text-gray-700")
                    ->last()
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".text-gray-800.leading-7.mt-1")->count() > 0)) {
                $description = $node
                    ->filter(".text-gray-800.leading-7.mt-1")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".w-full.h-32.rounded-t-lg")->count() > 0)) {
                $image = $node
                    ->filter(".w-full.h-32.rounded-t-lg")
                    ->first()
                    ->attr("style");

                $start = strpos($image, "(") + 1;
                $finish = strpos($image, ")");
                $image = substr($image, $start, $finish - $start);

                $contents = @file_get_contents($image);
                if ($contents) {
                    $filename = "io-" . date("d-m-y-h-i-s", time()) . ".jpg";
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
                "category" => "News",
                "date" => date("Y-m-d H:i:s", strtotime($date)),
                "image" => $image,
                "source" => "laravel.io",
            ];

            if (!empty($title)) {
                $this->articlesRepo->save($news);
            }
        }
    }
}
