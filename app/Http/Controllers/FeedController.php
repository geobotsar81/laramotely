<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index()
    {
        $jobs = Job::laravel()->notother()->whereDate('posted_date',Carbon::today())->orderBy('created_at','desc')->take(20)->get();

        return response()->view('feed', [
            'jobs' => $jobs,
        ])->header('Content-Type', 'text/xml');
    }
}
