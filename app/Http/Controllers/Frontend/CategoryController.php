<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\ArticleContract;
use App\Contracts\CategoryContract;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class CategoryController extends Controller
{
    private CategoryContract $categoryContract;

    public function __construct(CategoryContract $categoryContract)
    {
        $this->categoryContract = $categoryContract;
    }

    public function view(Request $request): View
    {
        $article = $this->categoryContract->getAllCategories();

    }
}
