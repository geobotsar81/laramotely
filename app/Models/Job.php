<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    public $appends = ["formated_date", "formated_created", "formated_location", "formated_tags"];

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
     * Generate a new attribute for a formated location
     *
     * @return string
     */
    public function getFormatedLocationAttribute(): string
    {
        $location = strip_tags($this->location);
        $location = str_replace("🌎", "", $location);
        return $location;
    }

    /**
     * Generate a new attribute for formated tags
     *
     * @return string
     */
    public function getFormatedTagsAttribute(): ?array
    {
        $tags = $this->tags;
        $tags = json_decode($this->tags);
        if (is_string($tags)) {
            $tags = explode(",", $tags);
        }

        return $tags;
    }

    /**
     * Scope for jobs with the Laravel keyword
     *
     * @param [type] $query
     * @return Builder
     */
    public function scopeLaravel($query): Builder
    {
        return $query
            ->where("title", "LIKE", "%laravel%")
            ->orWhere("description", "LIKE", "%laravel%")
            ->orWhere("location", "LIKE", "%laravel%")
            ->orWhere("tags", "LIKE", "%laravel%");
    }

    /**
     * Scope for jobs to exlclude unrelated keywords
     *
     * @param [type] $query
     * @return Builder
     */
    public function scopeNotother($query): Builder
    {
        return $query
            ->where("title", "NOT LIKE", "%wordpress%")
            ->where("description", "NOT LIKE", "%wordpress%")
            ->where("title", "NOT LIKE", "%WordPress%")
            ->where("description", "NOT LIKE", "%WordPress%")
            ->where("title", "NOT LIKE", "%.Net%")
            ->where("description", "NOT LIKE", "%.Net%")
            ->where("title", "NOT LIKE", "%Drupal%")
            ->where("description", "NOT LIKE", "%Drupal%")
            ->where("title", "NOT LIKE", "%Magento%")
            ->where("description", "NOT LIKE", "%Magento%");
    }

    /**
     * Scope for jobs that are published
     *
     * @param [type] $query
     * @return Builder
     */
    public function scopePublished($query): Builder
    {
        return $query->where("is_published", 1);
    }
}
