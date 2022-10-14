<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\NewsletterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name("job.")->group(function () {
    Route::get("/", [JobController::class, "showHome"])->name("home");
    Route::get("/job/{id}", [JobController::class, "show"])->name("show");
    Route::post("/get-jobs", [JobController::class, "index"])->name("index");
    Route::get("/post-a-job", [JobController::class, "postJob"])->name("post");
    Route::post("/post-job", [JobController::class, "sendJob"])->name("send");
});

Route::name("news.")->group(function () {
    Route::get("/laravel-news", [ArticlesController::class, "show"])->name("show");
    Route::get("/laravel-news/{id}", [ArticlesController::class, "showDetails"])->name("show-detail");
    Route::post("/get-news", [ArticlesController::class, "index"])->name("index");
});

Route::get("/contact", [ContactController::class, "show"])->name("contact.show");
Route::post("/contact", [ContactController::class, "sendMail"])->name("send-mail");

Route::post("/subscribe-newsletter", [NewsletterController::class, "subscribe"])->name("subscribe");
Route::get("/unsubscribe/{userID}", [NewsletterController::class, "unsubscribe"])->name("newsletter.unsubscribe");

Route::get("/sitemap.xml", [SitemapController::class, "index"]);
Route::get("/feed", [FeedController::class, "index"]);
Route::get("/newsfeed", [FeedController::class, "news"]);

Route::get("/privacy", [PrivacyController::class, "show"])->name("privacy.show");

//Admin routes
Route::group(["prefix" => "admin"], function () {
    Voyager::routes();
    Route::get("/scrape/{type}", [ScraperController::class, "scrape"])->name("scraper.scrape");
    Route::get("/healthcheck", [ScraperController::class, "healthcheck"])->name("scraper.healthcheck");
    Route::get("/test-notification", [JobController::class, "testNotification"])->name("job.testNotification");
});

//Route to test the scrapers
//

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');*/
