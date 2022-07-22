<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\ArticleContract;
use App\Http\Controllers\FrontendController;
use Illuminate\View\View;

class PagesController extends FrontendController
{
    public ArticleContract $articleContract;

    public function __construct(ArticleContract $articleContract)
    {
        $this->articleContract = $articleContract;
    }


    public function homepage(): View
    {
        $topArticles = $this->articleContract->getTopArticles()->take(10);

        return view('pages.homepage' , compact("topArticles"));
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function terms(): View
    {
        return view('pages.terms');
    }
}
