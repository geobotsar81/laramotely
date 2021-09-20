<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ScraperController;

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

Route::get('/job/{id}', [JobController::class,'show'])->name("job.show");
Route::get('/jobs', [JobController::class,'show'])->name("job.index");

Route::get('/contact', [ContactController::class,'show'])->name('contact.show');
Route::post('/contact', [ContactController::class,'sendMail'])->name('send-mail');

Route::get('/scrape/{type}', [ScraperController::class,'scrape'])->name("scraper.scrape");

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
