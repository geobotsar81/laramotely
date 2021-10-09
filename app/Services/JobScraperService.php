<?php
namespace App\Services;
use Goutte\Client;
use App\Models\Job;
use App\Services\Scraper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpClient\HttpClient;


class JobScraperService extends Scraper{


    public function scrape(){

        $jobs=Job::where('is_scraped',0)->where('source' ,'!=', 'linkedin.com')->where('source' ,'!=', 'ziprecruiter.co.uk')->where('source' ,'!=', 'workingnomads.co')->where('source' ,'!=', 'remotive.io')->where('source' ,'!=', 'remoteok.io')->orderBy('posted_date','DESC')->take(4)->get();

        if(!empty($jobs)){
            foreach($jobs as $job){
                echo $job->source.':'.$job->id.':'.$job->title."<br>";
                $url=$job->url;
                $source=$job->source;
                $description="";
                $tags="";

                if(!empty($url)){
                    
                    if($source == 'linkedin.com'){
                        $client = new Client(HttpClient::create(['timeout' => 120]));
                        $crawler = $client->request('GET', $url);

                        echo "Is linkedin<br>-------------";

                        if(!empty($crawler->filter('.show-more-less-html__markup')->count() > 0)){
                            $description = $crawler->filter('.show-more-less-html__markup')->first()->html();
                        }

                        $job->description=$description;
                        $job->is_scraped=1;
                        $job->save();
                    }

                    if($source == 'stackoverflow.com'){
                        $client = new Client(HttpClient::create(['timeout' => 120]));
                        $crawler = $client->request('GET', $url);

                        echo "Is stack overflow<br>-------------";

                        if(!empty($crawler->filter('.fs-body2 div')->count() > 0)){
                            $description = $crawler->filter('.fs-body2 div')->first()->html();
                        }
                        $job->description=$description;
                        $job->is_scraped=1;
                        $job->save();
                    }

                    if($source == 'weworkremotely.com'){
                        $client = new Client(HttpClient::create(['timeout' => 120]));
                        $crawler = $client->request('GET', $url);

                        echo "Is weworkremotely<br>-------------";

                        if(!empty($crawler->filter('.listing-container')->count() > 0)){
                            $description = $crawler->filter('.listing-container')->first()->html();
                        }
                        $job->description=$description;
                        $job->is_scraped=1;
                        $job->save();
                    }

                    if($source == 'arc.dev'){
                        $client = new Client(HttpClient::create(['timeout' => 120]));
                        $crawler = $client->request('GET', $url);

                        echo "Is arc.dev<br>-------------";

                        if(!empty($crawler->filter('.description')->count() > 0)){
                            $description = $crawler->filter('.description')->first()->html();
                        }
                        $job->description=$description;
                        $job->is_scraped=1;
                        $job->save();
                    }

                    if(($source == 'larajobs.com') || ($source == 'ziprecruiter.co')){
                        $client = new Client(HttpClient::create(['timeout' => 120]));
                        $crawler = $client->request('GET', $url);

                        echo "Is $source<br>-------------";

                        
                        if(!empty($crawler->filterXpath('//meta[@name="description"]')->count() > 0)){
                            $description =$crawler->filterXpath('//meta[@name="description"]')->attr('content');
                        }
                        $job->description=$description;
                        $job->is_scraped=1;
                        $job->save();
                    }

                    if($source == 'glassdoor.com'){
                        $client = new Client(HttpClient::create(['timeout' => 120]));
                        $crawler = $client->request('GET', $url);

                        echo "Is glassdoorv<br>-------------";

                        if(!empty($crawler->filter('.desc')->count() > 0)){
                            $description = $crawler->filter('.desc')->first()->html();
                        }
                        $job->description=$description;
                        $job->is_scraped=1;
                        $job->save();
                    }

                    if($source == 'simplyhired.com'){
                        $client = new Client(HttpClient::create(['timeout' => 120]));
                        $crawler = $client->request('GET', $url);

                        echo "Is simplyhired<br>-------------";

                        if(!empty($crawler->filter('.viewjob-jobDescription')->count() > 0)){
                            $description = $crawler->filter('.viewjob-jobDescription')->first()->html();
                        }
                        $job->description=$description;
                        $job->is_scraped=1;
                        $job->save();
                    }
                   
                }
            }
        }
        
    }
}