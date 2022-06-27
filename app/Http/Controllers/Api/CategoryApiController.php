<?php

namespace App\Http\Controllers\Api;

use App\Contracts\CategoryContract;
use App\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;

class CategoryApiController extends ApiController
{
    public CategoryContract $categoryContract;

    public function __construct(CategoryContract $categoryContract)
    {
        $this->categoryContract = $categoryContract;
    }

    public function index(): JsonResponse
    {
        return response()->json(new CategoryResource($this->categoryContract->getAllCategories()));
    }
}
