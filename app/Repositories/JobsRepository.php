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
        
        $foundUrl=$this->urlInDB($data["url"]);
        $foundTitle=$this->titleInDb($data["title"],$data["company"]);

        if( $foundUrl['found'] || $foundTitle['found']){
            echo "Already in db<br><br>";
            echo $data["title"].":".$data["url"]."<br><br>";

            $foundJob=($foundUrl['job']) ? $foundUrl['job'] : $foundTitle['job'];
            $foundJob->posted_date=$data["date"];
            $foundJob->created_at=$data["date"];
            $foundJob->save();

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
    public function urlInDB(string $url):Array{
        $job=Job::where('url',$url)->first();
        $found=(!empty($job)) ? true : false;
        $id=(!empty($job)) ? $job->id : null;
        echo "Url in DB:".$found.",".$url."<br>";
        return [
            'found' => $found,
            'job' => $job
        ];
    }

    /**
     * Find if a title for a job exists in database 
     *
     * @param string $url
     * @return boolean
     */
    public function titleInDb(string $title,string $company):Array{
        //$job=Job::where('title',$title)->where('company',$company)->where('posted_date',$date)->first();
        $job=Job::where('title',$title)->where('company',$company)->first();
        $found=(!empty($job)) ? true : false;
        $id=(!empty($job)) ? $job->id : null;
        echo "Title in DB:".$found.",".$title.",".$company."<br>";
        return [
            'found' => $found,
            'job' => $job
        ];
    }
}