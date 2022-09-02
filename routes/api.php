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

Route::middleware(["throttle:10,1"])->group(function () {
    Route::post("/v1/get-jobs", [ApiController::class, "getJobs"])->name("api.jobs.get");
    Route::post("/v1/post-jobs", [ApiController::class, "postJobs"])->name("api.jobs.post");
    Route::post("/v1/get-articles", [ApiController::class, "getArticles"])->name("api.articles.get");
});
