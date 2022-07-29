<?php

use App\Http\Controllers\Api\ArticleApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\FeedsApiController;
use App\Http\Controllers\Api\NewsBotApiController;
use App\Http\Controllers\Api\RelatedApiController;
use App\Http\Controllers\Api\VideoApiController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\VideoGenerator;
use App\Http\Controllers\Frontend\ArticleController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\PagesController;
use App\Http\Controllers\Frontend\RssController;
use App\Http\Controllers\Frontend\SitemapController;
use App\Http\Livewire\ArticlesComponent;
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
    return view('pages.homepage');
})->name('home');

Auth::routes();





Route::get('/', [PagesController::class, 'homepage'])->name('website.homepage');
Route::get('/about', [PagesController::class, 'about'])->name('website.about');
Route::get('/terms', [PagesController::class, 'terms'])->name('website.terms');
Route::get('/categories', [CategoryController::class, 'view'])->name('categories.view');
Route::get('/articles/{id}/{slug}', [ArticleController::class, 'view'])->name('article.view');
Route::get('/feed', [RssController::class, 'index'])->name('website.feed');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('website.sitemap');






Route::group(['prefix' => 'dashboard'], static function () {

    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/categories', [DashboardController::class, 'categories'])->name('dashboard.categories');
    Route::get('/feeds', [DashboardController::class, 'feeds'])->name('dashboard.feeds');
    Route::get('/articles', [DashboardController::class, 'articles'])->name('dashboard.articles');


    Route::group(['prefix' => 'videos'], static function () {
        Route::get('/generator/{article}', [VideoGenerator::class, 'generate'])->name('video.generate');
        Route::get('/upload/{article}', [VideoGenerator::class, 'upload'])->name('video.upload');
    });
});
