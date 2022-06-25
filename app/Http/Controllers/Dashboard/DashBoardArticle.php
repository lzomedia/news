<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\ArticleContract;

use App\Tables\ArticlesTable;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class DashBoardArticle extends Controller
{
    private ArticleContract $articleDatabaseContract;

    public function __construct(ArticleContract $articleDatabaseContract)
    {

        $this->articleDatabaseContract = $articleDatabaseContract;

        $this->middleware('auth');
    }

    public function articles(ArticlesTable $dataTable): View
    {
        $contract = $this->articleDatabaseContract;

        return $dataTable->render('dashboard.articles');
    }
}
