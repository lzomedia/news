<?php

namespace App\Http\Controllers\Api;

use App\Contracts\CategoryContract;
use App\Resources\CategoryResource;
use Illuminate\Http\Request;
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
        return response()->json(
            new CategoryResource($this->categoryContract->getAllCategories()->get())
        );
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            new CategoryResource($this->categoryContract->getCategoryById($id))
        );
    }

    public function delete(Request $request): JsonResponse
    {
        return response()->json(
            [
                "success" => $this->categoryContract->delete($request->id),
                "message" => "Category deleted successfully"
            ]
        );
    }
}
