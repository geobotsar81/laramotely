<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    public $appends = ['formated_date','formated_location','formated_tags'];


    public function getFormatedDateAttribute()
    {
        $formated_date=\Carbon\Carbon::createFromTimeStamp(strtotime($this->posted_date))->diffForHumans(); 
        return $formated_date;
    }

    public function getFormatedLocationAttribute()
    {  
        $location=strip_tags($this->location);
        $location=str_replace("🌎","",$location);
        return $location;
    }

    public function getFormatedTagsAttribute()
    {  
        $tags=$this->tags;
        $tags=json_decode($this->tags);
        if(!is_array($tags)){$tags=explode(',',$tags);}
        return  $tags;
    }
}
