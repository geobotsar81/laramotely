<?php

namespace App\Repositories;

use App\Models\Job;

class JobsRepository{


    /**
     * Save a job
     *
     * @param Array $data
     * @return void
     */
    public function save(Array $data):void{

        $job=new Job();
        $job->title= $data["title"];
        $job->url= $data["url"];
        $job->description= $data["description"];
        $job->posted_date= $data["date"];
        $job->location= $data["location"];
        $job->company= $data["company"];
        $job->company_logo= $data["company_logo"];
        $job->source= $data["source"];

       echo $data["title"].",".$data["source"]."<br>";

        $job->save();
    }


    /**
     * Find if a url for a job exists in database 
     *
     * @param string $url
     * @return boolean
     */
    public function urlInDB(string $url):bool{

        $job=Job::where('url',$url)->first();

        return (!empty($job)) ? true : false;
    }
}