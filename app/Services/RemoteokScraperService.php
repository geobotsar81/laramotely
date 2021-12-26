<?php
namespace App\Services;

use App\Services\Scraper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RemoteokScraperService extends Scraper
{
    /**
     * Scrape jobs from remoteok.io
     *
     * @return void
     */
    public function scrape():void
    {
        $url="https://remoteok.io/api";
        $response = Http::get($url);

        $counter=0;

        if (!empty($response->json())) {
            $jobs=$response->json();
            
            foreach ($jobs as $job) {
                if ($counter!=0) {
                    $title=$job['position'];
                    $url=$job['url'];
                    $company=$job['company'];
                    $tags=$job['tags'];
                    $date=date('Y-m-d H:i:s', strtotime($job['date']));
                    $description=$job['description'];
                    $company_logo=$job['company_logo'];
                    $location=$job['location'];

                    if ((strpos(strtolower($title), 'laravel') !== false) || (strpos(strtolower($description), 'laravel') !== false)) {
                        if (!empty($company_logo)) {
                            if (strpos($company_logo, "?") !== false) {
                                $company_logo = substr($company_logo, 0, strpos($company_logo, '?'));
                            }
                            $contents = @file_get_contents($company_logo);
                            if ($contents) {
                                Storage::disk('local')->put('public/companies/'.basename($company_logo), $contents);
                                $company_logo = basename($company_logo);
                            } else {
                                $company_logo="";
                            }
                        }

                        $job=[
                            'title' => $title,
                            'url' => $url,
                            'description' => $description,
                            'date' => $date,
                            'location' => $location,
                            'company' => $company,
                            'company_logo' => $company_logo,
                            'source' => 'remoteok.io',
                            'tags' => $tags
                        ];
                    
                       
                        $this->jobsRepo->save($job);
                    }
                }
                
                $counter++;
            }
        }
    }
}
