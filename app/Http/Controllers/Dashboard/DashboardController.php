<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\CategoryContract;
use App\Http\Livewire\ArticlesComponent;
use Illuminate\Contracts\View\View;

class DashboardController
{
    protected CategoryContract $categories;

    public function __construct(CategoryContract $categories)
    {
        $this->categories = $categories;
    }


    public function dashboard(): View
    {
        return view('dashboard.index');
    }


    public function categories(): View
    {
        $categories = $this->categories->getAllCategories()->get();
        return view('dashboard.categories.index', compact('categories'));
    }

    public function articles(ArticlesComponent $articlesComponent): View
    {
        return view('dashboard.articles.index');
    }

    public function feeds(): View
    {
        return view('dashboard.feeds.index');
    }

}
