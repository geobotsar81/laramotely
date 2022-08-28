<?php
namespace App\Services;

use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class LarajobsScraperService extends Scraper
{
    /**
     * Scrape jobs from larajobs.com
     *
     * @return void
     */
    public function scrape(): void
    {
        $url = "https://larajobs.com";
        $client = new Client(HttpClient::create(["timeout" => 60]));
        $crawler = $client->request("GET", $url);

        $nodes = $crawler->filter(".job-link");

        foreach ($nodes as $node) {
            $node = new Crawler($node);
            $tags = [];
            $company_logo = "";
            $url = $node->attr("data-url");

            if (strpos($url, "?") !== false) {
                $url = substr($url, 0, strpos($url, "?"));
            }

            $title = $node
                ->filter(".description")
                ->first()
                ->text();

            $company = $node
                ->filter("h4")
                ->first()
                ->text();

            $location = $node
                ->filter(".details .text-gray-600")
                ->first()
                ->text();

            if (!empty($node->filter("img")->count() > 0)) {
                $company_logo =
                    "https://larajobs.com/" .
                    $node
                        ->filter("img")
                        ->first()
                        ->attr("src");
                if (strpos($company_logo, "?") !== false) {
                    $company_logo = substr($company_logo, 0, strpos($company_logo, "?"));
                }
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

            $tags = $node->filter(".border-gray-400")->each(function ($node) use ($tags) {
                if (!empty($node)) {
                    $tag = $node->text();
                    array_push($tags, $tag);
                }

                return $tags[0];
            });
            $doNotSave = false;
            $date = $node
                ->filter(".flex.justify-end div:nth-child(2)")
                ->first()
                ->text();
            if (!empty($date)) {
                if (strpos($date, "h") !== false) {
                    $date = str_replace("h", "", $date);
                    $date = date("Y-m-d H:i:s", strtotime("-" . $date . " hours", strtotime(now())));
                } elseif (strpos($date, "d") !== false) {
                    $date = str_replace("d", "", $date);
                    $date = date("Y-m-d", strtotime("-" . $date * 1 . " days", strtotime(now())));
                } elseif (strpos($date, "w") !== false) {
                    $date = str_replace("w", "", $date);
                    $date = date("Y-m-d", strtotime("-" . $date * 14 . " days", strtotime(now())));
                } else {
                    $date = $node
                        ->filter(".flex.justify-end div:nth-child(1)")
                        ->first()
                        ->text();
                    if (!empty($date)) {
                        if (strpos($date, "h") !== false) {
                            $date = str_replace("h", "", $date);
                            $date = date("Y-m-d H:i:s", strtotime("-" . $date . " hours", strtotime(now())));
                        } elseif (strpos($date, "d") !== false) {
                            $date = str_replace("d", "", $date);
                            $date = date("Y-m-d", strtotime("-" . $date * 1 . " days", strtotime(now())));
                        } elseif (strpos($date, "w") !== false) {
                            $date = str_replace("w", "", $date);
                            $date = date("Y-m-d", strtotime("-" . $date * 14 . " days", strtotime(now())));
                        } elseif (strpos($date, "mos") !== false) {
                            $date = str_replace("mos", "", $date);
                            $date = date("Y-m-d", strtotime("-" . $date * 31 . " days", strtotime(now())));
                        } elseif (strpos($date, "mo") !== false) {
                            $date = str_replace("mo", "", $date);
                            $date = date("Y-m-d", strtotime("-" . 31 . " days", strtotime(now())));
                        } else {
                            $doNotSave = true;
                        }
                    } else {
                        $doNotSave = true;
                    }
                }
            } else {
                $doNotSave = true;
            }

            $job = [
                "title" => $title,
                "url" => $url,
                "description" => "",
                "date" => $date,
                "location" => $location,
                "company" => $company,
                "company_logo" => $company_logo,
                "source" => "larajobs.com",
                "tags" => $tags,
                "country" => "USA",
            ];

            if (!$doNotSave) {
                $this->jobsRepo->save($job);
            }
        }
    }
}
