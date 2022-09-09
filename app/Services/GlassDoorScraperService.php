<?php
namespace App\Services;

use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class GlassDoorScraperService extends Scraper
{
    /**
     * Scrape jobs from glassdoor.com
     *
     * @return void
     */
    public function scrape(): void
    {
        $url = "https://www.glassdoor.com/Job/laravel-jobs-SRCH_KO0,7.htm?fromAge=14";
        $client = new Client(HttpClient::create(["timeout" => 60]));
        $crawler = $client->request("GET", $url);

        $nodes = $crawler->filter(".react-job-listing");

        dd($nodes);
        foreach ($nodes as $node) {
            $node = new Crawler($node);

            $tags = [];
            $date = "";
            $company_logo = "";
            $company = "";
            $location = "";
            $description = "";

            $url =
                "https://www.glassdoor.com" .
                $node
                    ->filter(".job-search-key-1rd3saf")
                    ->first()
                    ->attr("href");
            $title = $node
                ->filter(".job-search-key-1rd3saf span")
                ->first()
                ->text();

            if (!empty($node->filter(".job-search-key-l2wjgv span")->count() > 0)) {
                $company = $node
                    ->filter(".job-search-key-l2wjgv span")
                    ->first()
                    ->text();
            }
            if (!empty($node->filter(".job-search-key-iii9i8")->count() > 0)) {
                $location = $node
                    ->filter(".job-search-key-iii9i8")
                    ->first()
                    ->text();
            }

            if (!empty($node->filter(".css-17n8uzw")->count() > 0)) {
                $date = $node
                    ->filter(".css-17n8uzw")
                    ->first()
                    ->text();
            }

            if (!empty($date)) {
                if (strpos($date, "h") !== false) {
                    $date = str_replace("h", "", $date);
                    $date = date("Y-m-d H", strtotime("-" . $date . " hours", strtotime(now())));
                } elseif (strpos($date, "d") !== false) {
                    $date = str_replace("d", "", $date);
                    $date = date("Y-m-d", strtotime("-" . $date * 1 . " days", strtotime(now())));
                } elseif (strpos($date, "w") !== false) {
                    $date = str_replace("w", "", $date);
                    $date = date("Y-m-d", strtotime("-" . $date * 14 . " days", strtotime(now())));
                }
            }

            if (!empty($node->filter("img")->count() > 0)) {
                $company_logo = $node
                    ->filter("img")
                    ->first()
                    ->attr("src");
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

            $job = [
                "title" => $title,
                "url" => $url,
                "description" => $description,
                "date" => $date,
                "location" => $location,
                "company" => $company,
                "company_logo" => $company_logo,
                "source" => "glassdoor.com",
                "tags" => $tags,
            ];

            $this->jobsRepo->save($job);
        }
    }
}
