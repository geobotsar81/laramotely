<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('created_at','desc')->get();

        return response()->view('feed', [
            'jobs' => $jobs,
        ])->header('Content-Type', 'text/xml');
    }
}
