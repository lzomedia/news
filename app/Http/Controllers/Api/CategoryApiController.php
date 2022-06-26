<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ArticleContract;
use App\Contracts\CategoryContract;
use App\Models\Category;
use App\Resources\ArticleResource;
use App\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;

class CategoryApiController extends ApiController
{

    public CategoryContract $categoryDatabaseContract;

    public function __construct(CategoryContract $categoryDatabaseContract)
    {
        $this->categoryDatabaseContract = $categoryDatabaseContract;
    }

    public function index(): JsonResponse
    {
        return response()->json(new CategoryResource($this->categoryDatabaseContract->getAllCategories()));
    }
}
