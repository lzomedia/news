<?php

namespace App\Http\Controllers\Api;


use App\Contracts\ArticleDatabaseContract;
use App\Contracts\FeedDatabaseContract;
use App\Contracts\SyncContract;
use App\Contracts\UserContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class FeedsApiController extends Controller
{

    private FeedDatabaseContract $feedDatabaseContract;
    private UserContract $userContract;



    public function __construct(
        FeedDatabaseContract $feedDatabaseContract,
        UserContract $userContract
    )
    {
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

}
