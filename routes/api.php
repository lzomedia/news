<?php

use App\Http\Controllers\Api\ArticleApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\FeedsApiController;
use App\Http\Controllers\Api\NewsBotApiController;
use App\Http\Controllers\Api\RelatedApiController;
use App\Http\Controllers\Api\VideoApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/v1'], static function () {
    Route::get('/articles', [ArticleApiController::class, 'index']);
    Route::get('/categories', [CategoryApiController::class, 'index']);
    Route::get('/articles/related/{articleID}', [RelatedApiController::class, '__invoke']);
    Route::get('/article/{articleID}', [ArticleApiController::class, 'getArticle']);
    Route::get('/feeds/find/{topic}', [FeedsApiController::class, 'find']);
    Route::get('/feeds', [FeedsApiController::class, 'index']);
    Route::post('/bot', [NewsBotApiController::class, '__invoke'])->middleware('throttle:10,1');
    Route::post('/generator/{articleID}/audio', [VideoApiController::class, 'generateAudio']);
    Route::post('/feeds/save', [FeedsApiController::class, 'save']);
});

