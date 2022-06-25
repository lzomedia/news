<?php

namespace App\Http\Controllers\Api;

use App\Contracts\FeedContract;
use App\Contracts\UserContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

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

    //todo make this to accept a null user id and return all feeds
    public function index(): JsonResponse
    {
        return response()->json(
            $this->feedDatabaseContract->getAllFeeds(
                $this->userContract
            )
        );
    }
}
