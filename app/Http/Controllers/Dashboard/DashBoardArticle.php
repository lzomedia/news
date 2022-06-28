<?php

namespace App\Http\Controllers\Dashboard;

use App\Tables\ArticlesTable;
use Illuminate\Routing\Controller;

class DashBoardArticle extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function articles(ArticlesTable $dataTable):mixed
    {
        return $dataTable->render('dashboard.articles');
    }
}
