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

class FeedsApiController extends Controller
{
    private FeedContract $feedDatabaseContract;
    private UserContract $userContract;
    private ArticleContract $articleContract;



    public function __construct(
        FeedContract $feedDatabaseContract,
        UserContract $userContract,
        ArticleContract $articleContract
    ) {
        $this->feedDatabaseContract = $feedDatabaseContract;
        $this->userContract = $userContract;
        $this->articleContract = $articleContract;
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

    public function save(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $exist = Feed::where('url', $data['url'])->exists();
        if (!$exist) {
            $feed = new Feed();
            $feed->fill($data);
            $feed->save();
            dispatch(new ProcessFeeds($feed->id, $this->articleContract));
            return response()->json($feed);
        }
        return response()->json(['error' => 'Feed already exists']);
    }
}
