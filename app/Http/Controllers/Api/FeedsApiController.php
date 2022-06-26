<?php

namespace App\Http\Controllers\Api;

use App\Contracts\FeedContract;
use App\Contracts\UserContract;
use App\DTO\FeedFinder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\DomCrawler\Crawler;

class FeedsApiController extends Controller
{
    private FeedContract $feedDatabaseContract;
    private UserContract $userContract;



    public function __construct(
        FeedContract $feedDatabaseContract,
        UserContract $userContract
    ) {
        $this->feedDatabaseContract = $feedDatabaseContract;
        $this->userContract = $userContract;
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->feedDatabaseContract->getAllFeeds(
                $this->userContract
            )
        );
    }

    /**
     * @throws \JsonException
     * @throws UnknownProperties
     */
    public function find(Request $request): JsonResponse
    {

        $data = Http::get('https://feedly.com/v3/recommendations/topics/'.$request->topic.'?locale=en')
            ->body();

        $finder = new FeedFinder(
            json_decode($data, true, 512, JSON_THROW_ON_ERROR)
        );

        $data = [
            'feeds' => $finder->getFeeds(),
            'topics' => $finder->getTopics(),
        ];

        return response()->json($data);
    }

    public function save(Request $request)
    {
        $data = $request->toArray();
        dd($data);
    }
}
