<?php

namespace App\Repositories;

use App\Models\Job;

class JobsRepository
{
    /**
     * Save a job
     *
     * @param Array $data
     * @return void
     */
    public function save(array $data): void
    {
        $job = new Job();
        $job->title = $data["title"];
        $job->url = $data["url"];
        $job->description = $data["description"];
        $job->posted_date = $data["date"];
        $job->location = $data["location"];
        $job->company = $data["company"];
        $job->company_logo = $data["company_logo"];
        $job->source = $data["source"];
        $job->is_scraped = 0;
        if ($data["source"] == "linkedin.com" || $data["source"] == "glassdoor.com") {
            $job->is_scraped = 1;
        }

        $job->is_published = 1;
        $job->tags = json_encode($data["tags"]);

        $job->country = $data["country"] ?? "";
        $job->salary = $data["salary"] ?? "";

        $foundUrl = $this->urlInDB($data["url"]);
        $foundTitle = $this->titleInDb($data["title"], $data["company"]);

        if (!$foundUrl["found"] && !$foundTitle["found"]) {
            if (strpos(strtolower($data["title"]), "wordpress") === false) {
                $job->save();
            }
        }
    }

    /**
     * Find if a url for a job exists in database
     *
     * @param string $url
     * @return array
     */
    public function urlInDB(string $url): array
    {
        $job = Job::where("url", $url)->first();
        $found = !empty($job) ? true : false;
        $id = !empty($job) ? $job->id : null;
        //echo "Url in DB:" . $found . "," . $url . "<br>";
        return [
            "found" => $found,
            "job" => $job,
        ];
    }

    /**
     * Find if a title for a job exists in database
     *
     * @param string $url
     * @return array
     */
    public function titleInDb(string $title, ?string $company): array
    {
        //$job=Job::where('title',$title)->where('company',$company)->where('posted_date',$date)->first();
        $found = false;
        $job = null;

        if ($company) {
            $job = Job::where("title", $title)
                ->where("company", $company)
                ->first();

            $found = !empty($job) ? true : false;
            $id = !empty($job) ? $job->id : null;
        }

        //echo "Title in DB:" . $found . "," . $title . "," . $company . "<br>";
        return [
            "found" => $found,
            "job" => $job,
        ];
    }

    public function updateViews(int $jobId)
    {
        Job::whereId($jobId)->increment("views");
    }
}
