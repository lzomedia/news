<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ArticleContract;
use App\Contracts\FeedContract;
use App\Contracts\SyncContract;
use App\Contracts\UserContract;
use App\DTO\FeedFinder;
use App\Jobs\ProcessFeeds;
use App\Models\Feed;
use App\Requests\SaveFileRequest;
use App\Services\FeedService;
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
    private SyncContract $syncContract;



    public function __construct(
        FeedContract $feedDatabaseContract,
        UserContract $userContract,
        ArticleContract $articleContract,
        SyncContract $syncContract
    ) {
        $this->feedDatabaseContract = $feedDatabaseContract;
        $this->userContract = $userContract;
        $this->articleContract = $articleContract;
        $this->syncContract = $syncContract;
    }

    public function index(): JsonResponse
    {

        return response()->json([
            'success' => true,
            'message' => 'Request successful',
            'result' => $this->feedDatabaseContract->getAllFeeds($this->userContract)->toArray()
        ]);
    }

    /**
     * @throws \JsonException
     * @throws UnknownProperties
     */
    public function find(Request $request, FeedService $feedService): JsonResponse
    {

        $topic = $request->topic;

        $finder = $feedService->find($topic);

        return response()->json([
            'success' => true,
            'message' => 'Request successful',
            'result' => [
                'feeds' => $finder->getFeeds(),
                'topics' => $finder->getTopics(),
            ]
        ]);
    }

    public function save(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $exist = Feed::where('url', $data['url'])->exists();
        if (!$exist) {
            $feed = new Feed();
            $feed->fill($data);
            $feed->save();
            dispatch(new ProcessFeeds($feed->id));
            return response()->json([
                'success' => true,
                'message' => 'Request successful',
                'result' => $feed->toArray()
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Feed already exists',
        ]);
    }

}
