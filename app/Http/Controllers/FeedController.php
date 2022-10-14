<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Article;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class FeedController extends Controller
{
    /**
     * Generate a jobs XML feed to be used with social media
     *
     * @return void
     */
    public function index(): Response
    {
        $jobs = Job::laravel(false)
            ->notother()
            ->remote(false)
            ->whereDate("posted_date", ">=", Carbon::now()->subDays(7))
            ->orderBy("created_at", "desc")
            ->take(20)
            ->get();
        if (empty($jobs) || $jobs->count() == 0) {
            $jobs = Job::laravel(false)
                ->notother()
                ->remote(false)
                ->whereDate("posted_date", ">=", Carbon::now()->subDays(14))
                ->orderBy("created_at", "desc")
                ->take(20)
                ->get();
        }

        return response()
            ->view("feed", [
                "jobs" => $jobs,
            ])
            ->header("Content-Type", "text/xml");
    }

    public function news(): Response
    {
        $news = Article::orderBy("created_at", "desc")
            ->take(20)
            ->get();

        return response()
            ->view("feed", [
                "news" => $news,
            ])
            ->header("Content-Type", "text/xml");
    }
}
