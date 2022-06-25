<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ArticleContract;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryApiController extends ApiController
{
    public function index(): JsonResponse
    {
        return response()->json(
            Category::all()
        );
    }
}
