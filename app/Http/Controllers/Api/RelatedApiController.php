<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ArticleContract;
use App\Contracts\FeedContract;
use App\Contracts\UserContract;
use App\DTO\FeedFinder;
use App\Jobs\ProcessFeeds;
use App\Models\Feed;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class RelatedApiController extends Controller
{
    //generate invoke class
    public function __invoke(Request $request): JsonResponse
    {
        dd($request->all());
    }
}
