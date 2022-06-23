<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\ArticleContract;

use Illuminate\Routing\Controller;
use Illuminate\View\View;

class DashBoardArticle extends Controller
{
    private ArticleContract $articleDatabaseContract;

    public function __construct(
        ArticleContract $articleDatabaseContract
    ) {
        $this->articleDatabaseContract = $articleDatabaseContract;
        $this->middleware('auth');
    }

    public function articles(): View
    {
        $articles = $this->articleDatabaseContract->getAllArticles();

        return view('dashboard.articles', compact('articles'));
    }
}
