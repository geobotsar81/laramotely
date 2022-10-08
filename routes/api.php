<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});

Route::middleware(["throttle:40,1"])->group(function () {
    Route::post("/v1/get-jobs", [ApiController::class, "getJobs"])->name("api.jobs.get");
    Route::post("/v1/get-job", [ApiController::class, "getJob"])->name("api.job.get");
    Route::post("/v1/update-job-views", [ApiController::class, "updateJobViews"])->name("api.jobs.update-views");
    Route::post("/v1/get-favourites", [ApiController::class, "getFavourites"])->name("api.favourites.get");
    Route::post("/v1/post-jobs", [ApiController::class, "postJobs"])->name("api.jobs.post");
    Route::post("/v1/post-a-job", [ApiController::class, "postJob"])->name("api.job.post");
    Route::post("/v1/contact-us", [ApiController::class, "sendMail"])->name("api.contact");
    Route::post("/v1/get-articles", [ApiController::class, "getArticles"])->name("api.articles.get");
    Route::post("/v1/set-member-token", [ApiController::class, "setMemberToken"])->name("api.token.set");
});
