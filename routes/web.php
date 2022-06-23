<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Dashboard\DashBoardArticle;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedsController;
use App\Http\Controllers\VideoGenerator;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('homepage');
})->name('home');

Auth::routes();



Route::group(['prefix' => 'v1'], static function () {
    Route::get('/articles', [ArticleController::class, 'indexApi']);
});

RateLimiter::for('articles', static function (Request $request) {
    return Limit::none();
});



//@todo clean the frontend routes
Route::get('/articles/{id}/{slug}', [ArticleController::class, 'view'])
    ->name('article.view');


//todo clean up the dashboard routes
Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->name('dashboard');



Route::group(['prefix' => 'dashboard'], static function () {
    Route::post('feeds/import', [FeedsController::class, 'import'])
        ->name('feeds.import');

    Route::get('feeds/syncAll', [FeedsController::class, 'syncAll'])
        ->name('feeds.sync-all');

    Route::get('feeds/single/sync/{feed}', [FeedsController::class, 'syncSingle'])
        ->name('feeds.sync-single');

    Route::get('articles', [DashBoardArticle::class, 'articles'])
        ->name('dashboard.articles');

    Route::get('video/generator/{article}', [VideoGenerator::class, 'generate'])
        ->name('video.generate');

    Route::get('video/upload/{article}', [VideoGenerator::class, 'upload'])->name('video.upload');
});
