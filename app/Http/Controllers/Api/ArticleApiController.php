<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ArticleContract;
use Illuminate\Http\JsonResponse;

class ArticleApiController extends ApiController
{

    public ArticleContract $articleDatabaseContract;


    public function __construct(ArticleContract $articleDatabaseContract)
    {
        $this->articleDatabaseContract = $articleDatabaseContract;
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->articleDatabaseContract->getAllArticles()
        );
    }
}
