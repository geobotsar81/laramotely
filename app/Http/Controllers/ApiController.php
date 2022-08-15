<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * Return all the jobs for the home page based on the search criteria
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getJobs(Request $request): JsonResponse
    {
        $page = $request["page"];
        $search = $request["search"];
        $onlyRemote = $request["onlyRemote"];

        if ($onlyRemote) {
            $jobs = Job::where(function ($query) {
                $remoteSearch = "remote";
                $anywhereSearch = "anywhere";
                $query
                    ->where("title", "LIKE", "%{$remoteSearch}%")
                    ->orWhere("description", "LIKE", "%{$remoteSearch}%")
                    ->orWhere("location", "LIKE", "%{$remoteSearch}%")
                    ->orWhere("tags", "LIKE", "%{$remoteSearch}%")
                    ->orWhere("company", "LIKE", "%{$remoteSearch}%")
                    ->orWhere("title", "LIKE", "%{$anywhereSearch}%")
                    ->orWhere("description", "LIKE", "%{$anywhereSearch}%")
                    ->orWhere("location", "LIKE", "%{$anywhereSearch}%")
                    ->orWhere("tags", "LIKE", "%{$anywhereSearch}%")
                    ->orWhere("company", "LIKE", "%{$anywhereSearch}%");
            })
                ->where(function ($query) use ($search) {
                    $query
                        ->where("title", "LIKE", "%{$search}%")
                        ->orWhere("description", "LIKE", "%{$search}%")
                        ->orWhere("location", "LIKE", "%{$search}%")
                        ->orWhere("tags", "LIKE", "%{$search}%")
                        ->orWhere("company", "LIKE", "%{$search}%");
                })
                ->published()
                ->laravel()
                ->notother()
                ->orderBy("posted_date", "desc")
                ->paginate(50);
        } else {
            $jobs = Job::where("title", "LIKE", "%{$search}%")
                ->orWhere("description", "LIKE", "%{$search}%")
                ->orWhere("location", "LIKE", "%{$search}%")
                ->orWhere("tags", "LIKE", "%{$search}%")
                ->orWhere("company", "LIKE", "%{$search}%")
                ->published()
                ->laravel()
                ->notother()
                ->orderBy("posted_date", "desc")
                ->paginate(50);
        }

        return response()->json($jobs);
    }
}
