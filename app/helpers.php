<?php

use App\Models\Job;
use TCG\Voyager\Models\Page;
use TCG\Voyager\Models\Post;
use TCG\Voyager\Models\Category;
use Illuminate\Support\Facades\Cache;

function getJobsCount(){
    $cacheDuration=env("CACHE_DURATION");

    $jobscount = Cache::remember('jobscount', $cacheDuration, function (){
        return $jobs=Job::laravel()->notother()->get()->count();
    });

    return $jobscount;
}

function getSiteTitle(){
    $cacheDuration=env("CACHE_DURATION");

    $title = Cache::remember('site.title', $cacheDuration, function (){
        return setting('site.title');
    });

    return $title;
}

function getSiteDescription(){
    $cacheDuration=env("CACHE_DURATION");

    $description = Cache::remember('site.description', $cacheDuration, function (){
        return setting('site.description');
    });

    return $description;
}

function getPageSlug($pageID){
    $cacheDuration=env("CACHE_DURATION");

    $page = Cache::remember('page.id.'.$pageID, $cacheDuration, function () use($pageID){
        return Page::where("id",$pageID)->first();
    });

    if(!empty($page)){return $page->slug;}
    
}

function getPageFromSlug($slug){
    $cacheDuration=config("cache.duration");
    $page = Cache::remember('page.slug.'.$slug, $cacheDuration, function () use($slug){
        return Page::where(['slug' => $slug, 'status' => 'ACTIVE'])->first();
    });

    return $page;
    
}

function getPageSubpages($pageID){
    $cacheDuration=env("CACHE_DURATION");

    $subpages = Cache::remember('subpages.parent.'.$pageID, $cacheDuration, function () use($pageID){
        return Page::where("parent",$pageID)->get();
    });

    return $subpages;
}

//Caching
function clearSiteCaching(){
    Cache::flush();
}

function getMenu(Int $id){
    $cacheDuration=env("CACHE_DURATION");
    $menuName="";
    $menuItems=[];

    $menu = Cache::remember('menu.'.$id, $cacheDuration, function () use($id){
        return DB::select("select * from menus where id=$id");
    });

    if(!empty($menu)){$menuName=$menu[0]->name;}

    $items = Cache::remember('items.'.$id, $cacheDuration, function () use($id){
        return DB::select("select * from menu_items where menu_id=$id and parent_id IS NULL ORDER BY menu_items.order ASC");
    });

    if(!empty($items)){
        foreach($items as $item){
            
            $subitems = Cache::remember('subitems.'.$id, $cacheDuration, function () use($item){
                return DB::select("select * from menu_items where parent_id=$item->id ORDER BY menu_items.order ASC");
            });

            if(!empty($subitems)){
                $item->children=$subitems;
            }
            $menuItems[]=$item;
        }
    }

    return ["title" => $menuName,"items" => $menuItems];
}
