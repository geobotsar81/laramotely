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
    public function scrape(): void
    {
        $url = "https://www.simplyhired.com/search?q=laravel&l=Remote";
        $client = new Client(HttpClient::create(["timeout" => 60]));
        $crawler = $client->request("GET", $url);

        $nodes = $crawler->filter("#job-list li article");

        foreach ($nodes as $node) {
            $node = new Crawler($node);
            $tags = [];
            $company_logo = "";
            $location = "";
            $url =
                "https://www.simplyhired.com" .
                $node
                    ->filter(".jobposting-title a")
                    ->first()
                    ->attr("href");

            if (!empty($node->filter(".jobposting-title a")->count() > 0)) {
                $title = $node
                    ->filter(".jobposting-title a")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".jobposting-company")->count() > 0)) {
                $company = $node
                    ->filter(".jobposting-company")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".jobposting-location")->count() > 0)) {
                $location = $node
                    ->filter(".jobposting-location")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".jobposting-snippet")->count() > 0)) {
                $description = $node
                    ->filter(".jobposting-snippet")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter("time")->count() > 0)) {
                $date = date(
                    "Y-m-d H:i:s",
                    strtotime(
                        $node
                            ->filter("time")
                            ->first()
                            ->attr("datetime")
                    )
                );
            }

            $job = [
                "title" => $title,
                "url" => $url,
                "description" => $description,
                "date" => $date,
                "location" => $location,
                "company" => $company,
                "company_logo" => $company_logo,
                "source" => "simplyhired.com",
                "tags" => $tags,
                "country" => "USA",
            ];

            $this->jobsRepo->save($job);
        }
    }
}
