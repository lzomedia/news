<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FeedsController;
use App\Http\Controllers\HomeController;
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




Route::get('/dashboard', [HomeController::class, 'home'])->name('home');
Route::post('/feeds/sync', [FeedsController::class, 'import'])->name('feeds.import');
Route::get('/feeds/sync/{$feed}', [FeedsController::class, 'syncSingle'])->name('feeds.syncSingle');
Route::get('/feeds/sync', [FeedsController::class, 'syncAll'])->name('feeds.syncAll');
