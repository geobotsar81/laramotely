<?php

use Inertia\Inertia;
use App\Services\NewsletterService;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\JobController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\SitemapController;

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


Route::get('/', [PageController::class,'showHome'])->name("home.show");


Route::get('/jobs', [JobController::class,'all'])->name("jobs.show");
Route::get('/job/{id}', [JobController::class,'show'])->name("job.show");
Route::post('/get-jobs', [JobController::class,'index'])->name("job.index");
Route::get('/post-a-job', [JobController::class,'postJob'])->name("job.post");
Route::post('/post-job', [JobController::class,'sendJob'])->name('job.send');

Route::get('/contact', [ContactController::class,'show'])->name('contact.show');
Route::post('/contact', [ContactController::class,'sendMail'])->name('send-mail');

Route::get('/scrape/{type}', [ScraperController::class,'scrape'])->name("scraper.scrape");
Route::post('/subscribe-newsletter', [EmailController::class,'subscribe'])->name('subscribe');
//Route::get('/email', [NewsletterService::class,'sendEmails'])->name("newsletter.send");
Route::get('/unsubscribe/{userID}', [EmailController::class,'unsubscribe'])->name("newsletter.unsubscribe");

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/sitemap.xml', [SitemapController::class,'index']);
Route::get('/feed', [FeedController::class,'index']);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
