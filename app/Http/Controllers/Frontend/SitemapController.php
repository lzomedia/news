<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\ArticleContract;
use App\Http\Controllers\FrontendController;
use Illuminate\View\View;

class SitemapController extends FrontendController
{
    public function index(ArticleContract $articleContract): View
    {
        $articles = $articleContract->getAllArticles()->get();

        return view('pages.sitemap', compact('articles'));
    }
}
