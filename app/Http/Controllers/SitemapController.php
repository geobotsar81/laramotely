<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Display the jobs sitemap
     *
     * @return Response
     */
    public function index(): Response
    {
        $jobs = Job::orderBy("created_at", "desc")->get();

        return response()
            ->view("sitemap", [
                "jobs" => $jobs,
            ])
            ->header("Content-Type", "text/xml");
    }
}
