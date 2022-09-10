<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Page;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class PrivacyController extends Controller
{
    /**
     * Display the contact page
     *
     * @param string $slug
     * @return Response
     */
    public function show(string $slug = "privacy"): Response
    {
        $cacheDuration = env("CACHE_DURATION");
        $page = Cache::remember("page.slug." . $slug, $cacheDuration, function () use ($slug) {
            return Page::where(["slug" => $slug, "status" => "ACTIVE"])->firstOrFail();
        });

        return Inertia::render("Privacy/Index", [
            "page" => $page,
        ])->withViewData(["title" => $page->title, "description" => $page->meta_description, "url" => $page->slug]);
    }
}
