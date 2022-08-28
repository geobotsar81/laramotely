<?php
namespace App\Services;

use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class WwrScraperService extends Scraper
{
    /**
     * Scrape jobs from weworkremotely.com
     *
     * @return void
     */
    public function scrape(): void
    {
        $url = "https://weworkremotely.com/remote-jobs/search?term=laravel";
        $client = new Client(HttpClient::create(["timeout" => 60]));
        $crawler = $client->request("GET", $url);

        $nodes = $crawler->filter(".jobs li");
        foreach ($nodes as $node) {
            $node = new Crawler($node);
            $company_logo = "";
            $date = "";
            $tags = "";

            if (!empty($node)) {
                if ($node->filter(".title")->count() > 0) {
                    $title = $node
                        ->filter(".title")
                        ->first()
                        ->text();
                    $url =
                        "https://weworkremotely.com" .
                        $node
                            ->filter('a[href*="remote-jobs"]')
                            ->first()
                            ->attr("href");
                    $title = $node
                        ->filter(".title")
                        ->first()
                        ->text();
                    $company = $node
                        ->filter(".company")
                        ->first()
                        ->text();
                    $location = $node
                        ->filter(".region")
                        ->first()
                        ->text();

                    if ($node->filter("time")->count() > 0) {
                        $date = $node
                            ->filter("time")
                            ->first()
                            ->attr("datetime");
                        $date = date("Y-m-d", strtotime($date));
                    } else {
                        $date = now();
                    }

                    if (!empty($node->filter(".flag-logo")->count() > 0)) {
                        $company_logo = $node
                            ->filter(".flag-logo")
                            ->first()
                            ->attr("style");
                        if (strpos($company_logo, "?") !== false) {
                            $company_logo = substr($company_logo, 21, strpos($company_logo, "?") - 21);
                        }
                        //echo $company_logo."<br>";
                        $contents = @file_get_contents($company_logo);
                        if ($contents) {
                            $extension = pathinfo($company_logo, PATHINFO_EXTENSION);
                            $filename = $company ? Str::slug($company, "-") : basename($company_logo);
                            Storage::disk("local")->put("public/companies/" . $filename . "." . $extension, $contents);
                            $company_logo = $filename . "." . $extension;
                        } else {
                            $company_logo = "";
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
                        "source" => "weworkremotely.com",
                        "tags" => $tags,
                        "country" => "USA",
                    ];

                    $this->jobsRepo->save($job);
                }
            }
        }
    }
}
