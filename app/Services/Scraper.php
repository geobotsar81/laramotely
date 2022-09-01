<?php
namespace App\Services;

use App\Repositories\JobsRepository;
use App\Repositories\ArticlesRepository;

abstract class Scraper
{
    protected $jobsRepo;
    protected $articlesRepo;

    public function __construct()
    {
        $this->jobsRepo = new JobsRepository();
        $this->articlesRepo = new ArticlesRepository();
    }
    abstract public function scrape();
}
