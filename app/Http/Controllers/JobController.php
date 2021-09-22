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

        return Inertia::render('Jobs/Show',$data);
    }

    /**
     * Show the job
     * 
     * @return void
     */
    public function index(Request $request){
        $page=$request['page'];
        $search=$request['search'];
        
        $jobs=Job::where('title', 'LIKE', "%{$search}%")->orderBy('posted_date','desc')->paginate(8);
       
         return response()->json($jobs);
     }
}
