<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    public $appends = ['formated_date','formated_location'];


    public function getFormatedDateAttribute()
    {
        $formated_date=\Carbon\Carbon::createFromTimeStamp(strtotime($this->posted_date))->diffForHumans(); 
        return $formated_date;
    }

    public function getFormatedLocationAttribute()
    {
        return (strip_tags($this->location));
    }
}
