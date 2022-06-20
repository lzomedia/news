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
    private SyncContract $syncContract;


    public function __construct(
        FeedDatabaseContract $feedDatabaseContract,
        SyncContract $syncContract
    )
    {
        $this->feedDatabaseContract = $feedDatabaseContract;
        $this->syncContract = $syncContract;

    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->feedDatabaseContract->getAllArticles()
        );
    }

}
