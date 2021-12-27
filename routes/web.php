<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ContactController;
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


Route::get('/', [JobController::class,'showHome'])->name("job.home");
Route::get('/job/{id}', [JobController::class,'show'])->name("job.show");
Route::post('/get-jobs', [JobController::class,'index'])->name("job.index");
Route::get('/post-a-job', [JobController::class,'postJob'])->name("job.post");
Route::post('/post-job', [JobController::class,'sendJob'])->name('job.send');

Route::get('/contact', [ContactController::class,'show'])->name('contact.show');
Route::post('/contact', [ContactController::class,'sendMail'])->name('send-mail');

Route::post('/subscribe-newsletter', [NewsletterController::class,'subscribe'])->name('subscribe');
Route::get('/unsubscribe/{userID}', [NewsletterController::class,'unsubscribe'])->name("newsletter.unsubscribe");

Route::get('/sitemap.xml', [SitemapController::class,'index']);
Route::get('/feed', [FeedController::class,'index']);

//Admin routes
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

//Route to test the scrapers
//Route::get('/scrape/{type}', [ScraperController::class,'scrape'])->name("scraper.scrape");


/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');*/
