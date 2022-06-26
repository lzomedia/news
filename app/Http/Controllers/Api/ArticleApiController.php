<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ArticleContract;
use App\Models\Category;
use App\Resources\ArticleResource;
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

        return response()->json([
            'success' => 'true',
            'message'=>'Request successful',
            'categories' => Category::orderBy('count', 'desc')->get(),
            'result' => ArticleResource::collection((
                $this->articleDatabaseContract->getAllArticles()->paginate(5)
            ))->response()->getData()
        ]);
    }
}
