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
        $job->is_scraped= 0;
        $job->is_published= 1;
        $job->tags= json_encode($data["tags"]);
        
        if($this->urlInDB($data["url"]) || $this->titleInDb($data["title"],$data["company"])){
            echo "Already in db<br><br>";
        }else{
            echo "Not Found:".$data["title"].",".$data["source"]."<br><br>";
            $job->save();
        }
      

       
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

    /**
     * Find if a title for a job exists in database 
     *
     * @param string $url
     * @return boolean
     */
    public function titleInDb(string $title,string $company):bool{

        $job=Job::where('title',$title)->where('company',$company)->first();

        return (!empty($job)) ? true : false;
    }
}