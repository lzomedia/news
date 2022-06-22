<?php

namespace App\Http\Controllers\Api;


use App\Contracts\ArticleDatabaseContract;
use App\Contracts\FeedDatabaseContract;
use App\Contracts\SyncContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class FeedsApiController extends Controller
{

    private FeedDatabaseContract $feedDatabaseContract;



    public function __construct(FeedDatabaseContract $feedDatabaseContract)
    {
        $this->feedDatabaseContract = $feedDatabaseContract;
    }

    public function index(): JsonResponse
    {
        $user = Auth::user();

        if($user === NULL){
            throw new \RuntimeException('User is not authenticated');
        }

        return response()->json(
            $this->feedDatabaseContract->getAllFeeds($user)
        );
    }

}
