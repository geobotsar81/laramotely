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
        $onlyRemote=$request['onlyRemote'];

        
        if($onlyRemote){
            $jobs=Job:: where(function ($query) {
                $remoteSearch="remote";
                $anywhereSearch="anywhere";
                $query->where('title', 'LIKE', "%{$remoteSearch}%")
                ->orWhere('description', 'LIKE', "%{$remoteSearch}%")
                ->orWhere('location', 'LIKE', "%{$remoteSearch}%")
                ->orWhere('tags', 'LIKE', "%{$remoteSearch}%")
                ->orWhere('company', 'LIKE', "%{$remoteSearch}%")
                ->orWhere('title', 'LIKE', "%{$anywhereSearch}%")
                ->orWhere('description', 'LIKE', "%{$anywhereSearch}%")
                ->orWhere('location', 'LIKE', "%{$anywhereSearch}%")
                ->orWhere('tags', 'LIKE', "%{$anywhereSearch}%")
                ->orWhere('company', 'LIKE', "%{$anywhereSearch}%");
            })
            ->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('location', 'LIKE', "%{$search}%")
                ->orWhere('tags', 'LIKE', "%{$search}%")
                ->orWhere('company', 'LIKE', "%{$search}%");
            })
            ->orderBy('posted_date','desc')->paginate(8);
        }else{
            $jobs=Job::where('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('location', 'LIKE', "%{$search}%")
            ->orWhere('tags', 'LIKE', "%{$search}%")
            ->orWhere('company', 'LIKE', "%{$search}%")
            ->orderBy('posted_date','desc')->paginate(8);
        }
        
       
         return response()->json($jobs);
     }
}
