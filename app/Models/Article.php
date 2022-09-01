<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    public $appends = ["formated_date", "formated_created", "formated_image"];

    /**
     * Generate a new attribute for a formated post date
     *
     * @return string
     */
    public function getFormatedDateAttribute(): string
    {
        $formated_date = \Carbon\Carbon::createFromTimeStamp(strtotime($this->posted_date))->diffForHumans();
        return $formated_date;
    }

    /**
     * Generate a new attribute for a formated created date
     *
     * @return string
     */
    public function getFormatedCreatedAttribute(): string
    {
        $formated_date = \Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
        return $formated_date;
    }

    /**
     * Generate a new attribute for images that exist
     *
     * @return string
     */
    public function getFormatedImageAttribute()
    {
        $image = $this->company_logo;
        $file = public_path("storage/companies/" . $image);

        return file_exists($file) ? $image : "";
    }
}
