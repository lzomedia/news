<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ArticleContract;
use App\Models\Category;
use App\Resources\ArticleResource;
use Illuminate\Http\JsonResponse;

class ArticleApiController extends ApiController
{
    public ArticleContract $articleContract;


    public function __construct(ArticleContract $articleContract)
    {
        $this->articleContract = $articleContract;
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => 'true',
            'message'=>'Request successful',
            'categories' => Category::orderBy('count', 'desc')
                ->limit(10)->get(),
            'result' => ArticleResource::collection((
                $this->articleContract->getAllArticles()->paginate(5)
            ))->response()->getData()
        ]);
    }

    public function getArticle(int $articleID): JsonResponse
    {
        return response()->json([
            'success' => 'true',
            'message'=>'Request successful',
            'result' => new ArticleResource($this->articleContract->getArticleById($articleID))
        ]);
    }
}
