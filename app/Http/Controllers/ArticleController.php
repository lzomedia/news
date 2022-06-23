<?php

namespace App\Http\Controllers;

use App\Contracts\ArticleContract;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    private ArticleContract $articleDatabaseContract;

    public function __construct(
        ArticleContract $articleDatabaseContract
    ) {
        $this->articleDatabaseContract = $articleDatabaseContract;
    }


    public function view(Request $request): View
    {
        $id = $request->id;

        $article = $this->articleDatabaseContract->getArticleById($id);

        return view('article-view', [
            'article' =>$article,
        ]);
    }

    public function indexApi(): JsonResponse
    {
        return response()->json(
            $this->articleDatabaseContract->getAllArticles()
        );
    }
}
