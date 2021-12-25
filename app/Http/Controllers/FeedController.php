<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class FeedController extends Controller
{
    /**
     * Generate a jobs XML feed to be used with social media
     *
     * @return void
     */
    public function index():Response
    {
        $jobs = Job::laravel()->notother()->whereDate('posted_date', '>=', Carbon::today())->orderBy('created_at', 'desc')->take(20)->get();
        if (empty($jobs) || $jobs->count() == 0) {
            $jobs = Job::laravel()->notother()->whereDate('posted_date', '>=', Carbon::yesterday())->orderBy('created_at', 'desc')->take(20)->get();
        }
        
        return response()->view('feed', [
            'jobs' => $jobs,
        ])->header('Content-Type', 'text/xml');
    }
}
