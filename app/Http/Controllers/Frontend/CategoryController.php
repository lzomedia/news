<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\CategoryContract;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class CategoryController extends Controller
{
    private CategoryContract $categoryContract;

    public function __construct(CategoryContract $categoryContract)
    {
        $this->categoryContract = $categoryContract;
    }

    public function view(): View
    {

        return view('pages.categories', [
            'categories' => $this->categoryContract->getAllCategories()->simplePaginate(25),
        ]);
    }
}
