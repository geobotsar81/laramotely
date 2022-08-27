<?php
namespace App\Services;

use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class ReedjobsScraperService extends Scraper
{
    /**
     * Scrape jobs from larajobs.com
     *
     * @return void
     */
    public function scrape(): void
    {
        $url = "https://www.reed.co.uk/jobs/laravel-jobs?sortby=DisplayDate";
        $client = new Client(HttpClient::create(["timeout" => 600]));
        $crawler = $client->request("GET", $url);
        $nodes = $crawler->filter(".job-result-card");

        foreach ($nodes as $node) {
            $node = new Crawler($node);

            $tags = [];
            $company_logo = "";
            $location = "";
            $url = "";
            $title = "";
            $company = "";

            if (!empty($node->filter("h3 a")->count() > 0)) {
                $url =
                    "https://www.reed.co.uk" .
                    $node
                        ->filter("h3 a")
                        ->first()
                        ->attr("href");
            }

            if (!empty($node->filter("h3 a")->count() > 0)) {
                $title = $node
                    ->filter("h3 a")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".job-result-heading__posted-by a")->count() > 0)) {
                $company = $node
                    ->filter(".job-result-heading__posted-by a")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".job-metadata__item--location")->count() > 0)) {
                $location = $node
                    ->filter(".job-metadata__item--location")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".job-result-logo__img")->count() > 0)) {
                $company_logo = $node
                    ->filter(".job-result-logo__img")
                    ->first()
                    ->attr("data-src");
                if (strpos($company_logo, "?") !== false) {
                    $company_logo = substr($company_logo, 0, strpos($company_logo, "?"));
                }
                $contents = @file_get_contents($company_logo);
                if ($contents) {
                    Storage::disk("local")->put("public/companies/" . basename($company_logo), $contents);
                    $company_logo = basename($company_logo);
                } else {
                    $company_logo = "";
                }
            }

            if (!empty($node->filter(".job-result-heading__posted-by")->count() > 0)) {
                $date = $node
                    ->filter(".job-result-heading__posted-by")
                    ->first()
                    ->text();

                $date = str_replace(" by", "", $date);
                if (!empty($date)) {
                    if (strpos($date, "hours") !== false) {
                        $date = str_replace("hours", "", $date);
                        $date = date("Y-m-d H:i:s", strtotime("-" . $date . " hours", strtotime(now())));
                    } elseif (strpos($date, "yesterday") !== false) {
                        $date = date("Y-m-d", strtotime("-1 days", strtotime(now())));
                    } elseif (strpos($date, "day ago") !== false) {
                        $date = str_replace("day ago", "", $date);
                        $date = date("Y-m-d", strtotime("-" . $date * 1 . " days", strtotime(now())));
                    } elseif (strpos($date, "days ago") !== false) {
                        $date = str_replace("days ago", "", $date);
                        $date = date("Y-m-d", strtotime("-" . $date * 1 . " days", strtotime(now())));
                    } else {
                        $date = now();
                    }
                }
            }
            if ($url) {
                $job = [
                    "title" => $title,
                    "url" => $url,
                    "description" => "",
                    "date" => $date,
                    "location" => $location,
                    "company" => $company,
                    "company_logo" => $company_logo,
                    "source" => "reed.co.uk",
                    "country" => "UK",
                    "tags" => $tags,
                ];

                $this->jobsRepo->save($job);
            }
        }
    }
}
