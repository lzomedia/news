<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\ArticleContract;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ArticleController extends Controller
{
    private ArticleContract $articleContract;

    public function __construct(ArticleContract $articleContract)
    {
        $this->articleContract = $articleContract;
    }

    public function view(Request $request): View
    {

        $article = $this->articleContract->getArticleById($request->id);

        return view('pages.article-view', [
                'article' =>$article,
            ]
        );
    }
}
