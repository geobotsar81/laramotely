<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    /**
     * Display the welcome page
     *
     * @return Response
     */
    public function showHome():Response
    {
        $page=getPageFromSlug("/");
        $data=[];

        $jobs=Job::orderBy('posted_date', 'desc')->paginate(8);

        if (!empty($page)) {
            $data=['title' => $page->title." - Laramotely",'description' => $page->meta_description,'url' =>route('home.show')];
        }

        $data['jobs']=$jobs;
        return Inertia::render('Home/Index', $data)->withViewData(['title' => 'Laramotely - '.$page->title,'description' => $page->meta_description,'url' => route('home.show')]);
    }
}
