<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('created_at','desc')->get();

        return response()->view('sitemap', [
            'jobs' => $jobs,
        ])->header('Content-Type', 'text/xml');
    }
}
