<?php

namespace App\Http\Controllers\Api;


use App\Contracts\ArticleDatabaseContract;
use App\Contracts\FeedDatabaseContract;
use App\Contracts\SyncContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class FeedsApiController extends Controller
{

    private FeedDatabaseContract $feedDatabaseContract;



    public function __construct(FeedDatabaseContract $feedDatabaseContract)
    {
        $this->feedDatabaseContract = $feedDatabaseContract;
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->feedDatabaseContract->getAllFeeds()
        );
    }

}
