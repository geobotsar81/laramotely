<?php
namespace App\Services;

use Goutte\Client;
use App\Services\Scraper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpClient\HttpClient;

class RemotiveScraperService extends Scraper
{
    /**
     * Scrape jobs from remotive.io
     *
     * @return void
     */
    public function scrape(): void
    {
        $url = "https://remotive.com/api/remote-jobs?search=laravel";
        $response = Http::get($url);

        if (!empty($response->json())) {
            $results = $response->json();
            $jobs = $results["jobs"];
            $tags = "";

            foreach ($jobs as $job) {
                $company_logo = "";

                $title = $job["title"];
                $url = $job["url"];
                $company = $job["company_name"];
                if (!empty($job["company_logo"])) {
                    $company_logo = $job["company_logo"];
                    if (strpos($company_logo, "?") !== false) {
                        $company_logo = substr($company_logo, 0, strpos($company_logo, "?"));
                    }
                    $contents = @file_get_contents($company_logo);
                    if ($contents) {
                        $extension = "png";
                        $filename = $company ? Str::slug($company, "-") : basename($company_logo);
                        Storage::disk("local")->put("public/companies/" . $filename . "." . $extension, $contents);
                        $company_logo = $filename . "." . $extension;
                    } else {
                        $company_logo = "";
                    }
                }
                $tags = $job["category"];
                $date = $job["publication_date"];
                $description = $job["description"];
                $location = $job["candidate_required_location"];

                $job = [
                    "title" => $title,
                    "url" => $url,
                    "description" => $description,
                    "date" => $date,
                    "location" => $location,
                    "company" => $company,
                    "company_logo" => $company_logo,
                    "source" => "remotive.io",
                    "tags" => $tags,
                ];

                $this->jobsRepo->save($job);
            }
        }
    }
}
