<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\ArticleContract;

use App\Tables\ArticlesTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class DashBoardArticle extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function articles(ArticlesTable $dataTable)
    {
        return $dataTable->render('dashboard.articles');
    }
}
