<?php
namespace App\Services;

use App\Repositories\JobsRepository;

abstract class Scraper
{
    protected $jobsRepo;

    public function __construct()
    {
        $this->jobsRepo = new JobsRepository();
    }
    abstract public function scrape();
}
