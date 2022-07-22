<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ArticleContract;
use App\Contracts\FeedContract;
use App\Contracts\UserContract;
use App\DTO\FeedFinder;
use App\Jobs\ProcessFeeds;
use App\Models\Article;
use App\Models\Category;
use App\Models\Feed;
use App\Resources\ArticleResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class NewsBotApiController extends Controller
{
    //generate invoke class
    public function __invoke(Request $request): JsonResponse
    {

        return response()->json([
            'success' => 'true',
            'message'=>'Request successful',
            'result' => ArticleResource::collection((
                []
            ))->response()->getData()
        ]);
    }
}
