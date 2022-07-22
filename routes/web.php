<?php

use App\Http\Controllers\Api\ArticleApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\FeedsApiController;
use App\Http\Controllers\Api\NewsBotApiController;
use App\Http\Controllers\Api\RelatedApiController;
use App\Http\Controllers\Api\VideoApiController;
use App\Http\Controllers\Dashboard\DashBoardArticle;
use App\Http\Controllers\Dashboard\DashboardFeeds;
use App\Http\Controllers\Dashboard\VideoGenerator;
use App\Http\Controllers\Dashboard\CategoryController as DashboardCategory;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontend\ArticleController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\PagesController;
use App\Http\Controllers\Frontend\SitemapController;
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



Route::group(['prefix' => '/api/v1'], static function () {
    Route::get('/articles', [ArticleApiController::class, 'index']);
    Route::get('/bot', [NewsBotApiController::class, '__invoke']);
    Route::get('/articles/related/{articleID}', [RelatedApiController::class, '__invoke']);
    Route::get('/article/{articleID}', [ArticleApiController::class, 'getArticle']);
    Route::get('/categories', [CategoryApiController::class, 'index']);
    Route::get('/feeds', [FeedsApiController::class, 'index']);
    Route::post('/feeds/save', [FeedsApiController::class, 'save']);
    Route::get('/feeds/find/{topic}', [FeedsApiController::class, 'find']);
    Route::post('/generator/{articleID}/audio', [VideoApiController::class, 'generateAudio']);
});

RateLimiter::for('articles', static function (Request $request) {
    return Limit::none();
});



Route::get('/', [PagesController::class, 'homepage'])->name('website.homepage');
Route::get('/about', [PagesController::class, 'about'])->name('website.about');
Route::get('/terms', [PagesController::class, 'terms'])->name('website.terms');
Route::get('/categories', [CategoryController::class, 'view'])->name('categories.view');
Route::get('/articles/{id}/{slug}', [ArticleController::class, 'view'])->name('article.view');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('website.sitemap');






Route::group(['prefix' => 'dashboard'], static function () {

    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::group(['prefix' => 'feeds'], static function () {
        Route::get('/', [DashboardFeeds::class, 'index'])->name('dashboard.feeds');
        Route::post('/import', [DashboardFeeds::class, 'import'])->name('feeds.import');
        Route::get('/find', [DashboardFeeds::class, 'find'])->name('feeds.finder');
        Route::get('/syncAll', [DashboardFeeds::class, 'syncAll'])->name('feeds.sync-all');
        Route::get('/single/sync/{feed}', [DashboardFeeds::class, 'syncSingle'])->name('feeds.sync-single');
    });

    Route::group(['prefix' => 'articles'], static function () {
        Route::get('/', [DashBoardArticle::class, 'articles'])->name('dashboard.articles');
    });

    Route::group(['prefix' => 'categories'], static function () {
        Route::get('/', [DashboardCategory::class, 'index'])->name('dashboard.categories');
        Route::get('/create', [DashboardCategory::class, 'create'])->name('dashboard.categories.create');
        Route::get('/edit', [DashboardCategory::class, 'edit'])->name('dashboard.categories.edit');
        Route::get('/destroy', [DashboardCategory::class, 'destroy'])->name('dashboard.categories.destroy');
        Route::get('/store', [DashboardCategory::class, 'store'])->name('dashboard.categories.store');
    });


    Route::group(['prefix' => 'videos'], static function () {
        Route::get('/generator/{article}', [VideoGenerator::class, 'generate'])->name('video.generate');
        Route::get('/upload/{article}', [VideoGenerator::class, 'upload'])->name('video.upload');
    });
});
