<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedsController;
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




Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->name('dashboard');
Route::post('/feeds/import', [FeedsController::class, 'import'])
    ->name('feeds.import');
Route::get('/feeds/syncAll', [FeedsController::class, 'syncAll'])
    ->name('feeds.sync-all');

Route::get('/feeds/single/sync/{feed}', [FeedsController::class, 'syncSingle'])
    ->name('feeds.sync-single');
