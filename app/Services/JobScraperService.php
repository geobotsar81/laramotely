<?php
namespace App\Services;

use Goutte\Client;
use App\Models\Job;
use App\Services\Scraper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpClient\HttpClient;

class JobScraperService extends Scraper
{
    /**
     * Get detailed description for scraped jobs
     *
     * @return void
     */
    public function scrape(): void
    {
        $jobs = Job::where("is_scraped", 0)
            ->where("source", "!=", "workingnomads.co")
            ->where("source", "!=", "remotive.io")
            ->where("source", "!=", "remoteok.io")
            ->orderBy("posted_date", "DESC")
            ->take(4)
            ->get();

        if (!empty($jobs)) {
            foreach ($jobs as $job) {
                echo $job->source . ":" . $job->id . ":" . $job->title . "<br>";
                $url = $job->url;
                $source = $job->source;
                $description = "";
                $tags = "";

                if (!empty($url)) {
                    if ($source == "www.linkedin.com") {
                        $job->is_scraped = 1;
                        $job->save();

                        $client = new Client(HttpClient::create(["timeout" => 120]));
                        $crawler = $client->request("GET", $url);

                        echo "Is linkedin<br>-------------";

                        if (!empty($crawler->filter(".show-more-less-html__markup")->count() > 0)) {
                            $description = $crawler
                                ->filter(".show-more-less-html__markup")
                                ->first()
                                ->html();
                        }

                        echo $description;

                        $job->description = $description;
                        $job->is_scraped = 1;
                        $job->save();
                    }

                    if ($source == "stackoverflow.com") {
                        $job->is_scraped = 1;
                        $job->save();

                        $client = new Client(HttpClient::create(["timeout" => 120]));
                        $crawler = $client->request("GET", $url);

                        echo "Is stack overflow<br>-------------";

                        if (!empty($crawler->filter(".fs-body2 div")->count() > 0)) {
                            $description = $crawler
                                ->filter(".fs-body2 div")
                                ->first()
                                ->html();
                        }
                        $job->description = $description;
                        $job->is_scraped = 1;
                        $job->save();
                    }

                    if ($source == "weworkremotely.com") {
                        $job->is_scraped = 1;
                        $job->save();

                        $client = new Client(HttpClient::create(["timeout" => 120]));
                        $crawler = $client->request("GET", $url);

                        echo "Is weworkremotely<br>-------------";

                        if (!empty($crawler->filter(".listing-container")->count() > 0)) {
                            $description = $crawler
                                ->filter(".listing-container")
                                ->first()
                                ->html();
                        }
                        $job->description = $description;
                        $job->is_scraped = 1;
                        $job->save();
                    }

                    if ($source == "cleverjobs.com") {
                        $job->is_scraped = 1;
                        $job->save();

                        $client = new Client(HttpClient::create(["timeout" => 120]));
                        $crawler = $client->request("GET", $url);

                        echo "Is cleverjobs<br>-------------";

                        if (!empty($crawler->filter("#main section .content.box.has-text-left")->count() > 0)) {
                            $description = $crawler
                                ->filter("#main section .content.box.has-text-left")
                                ->first()
                                ->html();
                        }
                        $job->description = $description;
                        $job->is_scraped = 1;
                        $job->save();
                    }

                    if ($source == "uklaraveljobs.com") {
                        $job->is_scraped = 1;
                        $job->save();

                        $client = new Client(HttpClient::create(["timeout" => 120]));
                        $crawler = $client->request("GET", $url);

                        echo "Is uklaraveljobs<br>-------------";

                        if (!empty($crawler->filter(".lead")->count() > 0)) {
                            $description = $crawler
                                ->filter(".lead")
                                ->first()
                                ->html();
                            $description = strip_tags($description, "<br><p>");
                        }

                        if (!empty($crawler->filter(".card-body.map-container .btn-primary")->count() > 0)) {
                            $url = $crawler
                                ->filter(".card-body.map-container .btn-primary")
                                ->first()
                                ->attr("href");
                            $job->url = $url;
                            echo "Url:" . $url;
                        }
                        $job->description = $description;
                        $job->is_scraped = 1;
                        $job->save();
                    }

                    if ($source == "arc.dev") {
                        $job->is_scraped = 1;
                        $job->save();

                        $client = new Client(HttpClient::create(["timeout" => 120]));
                        $crawler = $client->request("GET", $url);

                        echo "Is arc.dev<br>-------------";

                        if (!empty($crawler->filter(".description")->count() > 0)) {
                            $description = $crawler
                                ->filter(".description")
                                ->first()
                                ->html();
                        }
                        $job->description = $description;
                        $job->is_scraped = 1;
                        $job->save();
                    }

                    if ($source == "larajobs.com" || $source == "ziprecruiter.co.uk") {
                        $job->is_scraped = 1;
                        $job->save();

                        $client = new Client(HttpClient::create(["timeout" => 120]));
                        $crawler = $client->request("GET", $url);

                        echo "Is $source<br>-------------";

                        if (!empty($crawler->filterXpath('//meta[@name="description"]')->count() > 0)) {
                            $description = $crawler->filterXpath('//meta[@name="description"]')->attr("content");
                        }
                        $job->description = $description;
                        $job->is_scraped = 1;
                        $job->save();
                    }

                    if ($source == "glassdoor.com") {
                        $job->is_scraped = 1;
                        $job->save();

                        $client = new Client(HttpClient::create(["timeout" => 120]));
                        $crawler = $client->request("GET", $url);

                        echo "Is glassdoorv<br>-------------";

                        if (!empty($crawler->filter(".desc")->count() > 0)) {
                            $description = $crawler
                                ->filter(".desc")
                                ->first()
                                ->html();
                        }
                        $job->description = $description;
                        $job->is_scraped = 1;
                        $job->save();
                    }

                    if ($source == "simplyhired.com") {
                        $job->is_scraped = 1;
                        $job->save();

                        $client = new Client(HttpClient::create(["timeout" => 120]));
                        $crawler = $client->request("GET", $url);

                        echo "Is simplyhired<br>-------------";

                        if (!empty($crawler->filter(".viewjob-jobDescription")->count() > 0)) {
                            $description = $crawler
                                ->filter(".viewjob-jobDescription")
                                ->first()
                                ->html();
                        }
                        $job->description = $description;
                        $job->is_scraped = 1;
                        $job->save();
                    }

                    if ($source == "www.reed.co.uk") {
                        $job->is_scraped = 1;
                        $job->save();

                        $client = new Client(HttpClient::create(["timeout" => 120]));
                        $crawler = $client->request("GET", $url);

                        echo "Is reed<br>-------------";

                        if (!empty($crawler->filter(".description")->count() > 0)) {
                            $description = $crawler
                                ->filter(".description")
                                ->first()
                                ->html();
                        }
                        $job->description = $description;
                        $job->is_scraped = 1;
                        $job->save();
                    }
                }
            }
        }
    }
}
