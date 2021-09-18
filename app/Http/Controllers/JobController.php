<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Inertia\Inertia;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Show the job
     * 
     * @return void
     */
    public function show($id){
       $job=Job::where('id',$id)->firstOrFail();

       $data=['job' => $job];

        return Inertia::render('Job',$data);
    }
}
