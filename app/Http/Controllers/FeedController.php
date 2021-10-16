<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FeedController extends Controller
{
    public function index()
    {

        DB::enableQueryLog();

        $jobs = Job::laravel()->notother()->whereDate('posted_date','>=',Carbon::today())->orderBy('created_at','desc')->take(20)->get();
        if(empty($jobs)){
            $jobs = Job::laravel()->notother()->whereDate('posted_date','>=',Carbon::yesterday())->orderBy('created_at','desc')->take(20)->get();
        }

        dd($jobs);

        dd(DB::getQueryLog());
        
        return response()->view('feed', [
            'jobs' => $jobs,
        ])->header('Content-Type', 'text/xml');
    }
}
