<?php
namespace App\Services;

use Goutte\Client;
use App\Services\Scraper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class ZipRecruiterScraperService extends Scraper
{
    /**
     * Scrape jobs from ziprecruiter.co.uk
     *
     * @return void
     */
    public function scrape(): void
    {
        $url = "https://www.ziprecruiter.co.uk/Jobs/Laravel";
        $client = new Client(HttpClient::create(["timeout" => 120]));
        $crawler = $client->request("GET", $url);

        $nodes = $crawler->filter(".job-listing");

        dd($nodes);

        foreach ($nodes as $node) {
            $node = new Crawler($node);

            $tags = [];
            $logo = "";
            $url = $node
                ->filter(".jobList-title")
                ->first()
                ->attr("href");

            $title = $node
                ->filter(".jobList-title strong")
                ->first()
                ->text();
            $company = strip_tags(
                $node
                    ->filter(".jobList-introMeta li:nth-child(1)")
                    ->first()
                    ->text()
            );
            $location = strip_tags(
                $node
                    ->filter(".jobList-introMeta li:nth-child(2)")
                    ->first()
                    ->text()
            );
            $description = $node
                ->filter(".jobList-description")
                ->first()
                ->html();
            $date = $node
                ->filter(".jobList-date")
                ->first()
                ->text();

            if (!empty($date)) {
                $date = date("Y-m-d", strtotime($date . " 2021"));
            }

            $tags = "";

            $job = [
                "title" => $title,
                "url" => $url,
                "description" => $description,
                "date" => $date,
                "location" => $location,
                "company" => $company,
                "company_logo" => "",
                "source" => "ziprecruiter.co.uk",
                "tags" => $tags,
            ];
            dd($job);

            $this->jobsRepo->save($job);
        }
    }
}
