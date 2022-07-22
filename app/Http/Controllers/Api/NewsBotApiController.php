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
use Symfony\Component\Process\Process;

class NewsBotApiController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $url = $request->input('url');

        $response = collect();

        $process = new Process(
            [
                'python3',
                base_path('./python/extractor-realtime.py'),
                $url
            ]
        );

        $process->setTimeout(180);

        $process->run(
            function ($buffer) use ($response) {

                $data = json_decode(
                    $buffer,
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                );

                $response->push($data);
            }
        );



        return response()->json([
            'success' => 'true',
            'message'=>'Request successful',
            'result' => $response->toArray()
        ]);
    }
}
