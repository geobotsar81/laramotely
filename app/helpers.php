<?php

use App\Models\Job;
use TCG\Voyager\Models\Page;
use Illuminate\Support\Facades\Cache;

/**
 * Get the total number of jobs
 *
 * @return integer
 */
function getJobsCount():int
{
    $cacheDuration=env("CACHE_DURATION");

    $jobscount = Cache::remember('jobscount', $cacheDuration, function () {
        return $jobs=Job::laravel()->notother()->get()->count();
    });

    return $jobscount;
}

/**
 * Get the site title from the backend
 *
 * @return string
 */
function getSiteTitle():string
{
    $cacheDuration=env("CACHE_DURATION");

    $title = Cache::remember('site.title', $cacheDuration, function () {
        return setting('site.title');
    });

    return $title;
}

/**
 * Get the site description from the backend
 *
 * @return string
 */
function getSiteDescription():string
{
    $cacheDuration=env("CACHE_DURATION");

    $description = Cache::remember('site.description', $cacheDuration, function () {
        return setting('site.description');
    });

    return $description;
}

/**
 * Get the page slug provided its id
 *
 * @param integer $pageID
 * @return string
 */
function getPageSlug(int $pageID):string
{
    $cacheDuration=env("CACHE_DURATION");

    $page = Cache::remember('page.id.'.$pageID, $cacheDuration, function () use ($pageID) {
        return Page::where("id", $pageID)->first();
    });

    if (!empty($page)) {
        return $page->slug;
    }
}

/**
 * Get the Page object provided its slug
 *
 * @param string $slug
 * @return Page
 */
function getPageFromSlug(string $slug):Page
{
    $cacheDuration=config("cache.duration");
    $page = Cache::remember('page.slug.'.$slug, $cacheDuration, function () use ($slug) {
        return Page::where(['slug' => $slug, 'status' => 'ACTIVE'])->first();
    });

    return $page;
}


/**
 * Clear the website cache
 *
 * @return void
 */
function clearSiteCaching()
{
    Cache::flush();
}

/**
 * Get the menu elements
 *
 * @param integer $id
 * @return array
 */
function getMenu(int $id):array
{
    $cacheDuration=env("CACHE_DURATION");
    $menuName="";
    $menuItems=[];

    $menu = Cache::remember('menu.'.$id, $cacheDuration, function () use ($id) {
        return DB::select("select * from menus where id=$id");
    });

    if (!empty($menu)) {
        $menuName=$menu[0]->name;
    }

    $items = Cache::remember('items.'.$id, $cacheDuration, function () use ($id) {
        return DB::select("select * from menu_items where menu_id=$id and parent_id IS NULL ORDER BY menu_items.order ASC");
    });

    if (!empty($items)) {
        foreach ($items as $item) {
            $subitems = Cache::remember('subitems.'.$id, $cacheDuration, function () use ($item) {
                return DB::select("select * from menu_items where parent_id=$item->id ORDER BY menu_items.order ASC");
            });

            if (!empty($subitems)) {
                $item->children=$subitems;
            }
            $menuItems[]=$item;
        }
    }

    return ["title" => $menuName,"items" => $menuItems];
}
