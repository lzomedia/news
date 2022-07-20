<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\ArticleContract;
use App\Contracts\ReactionContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleController extends Controller
{
    private ArticleContract $articleContract;
    private ReactionContract $reactionContract;

    private Request $request;

    public function __construct(
        ArticleContract $articleContract,
        ReactionContract $reactionContract
    )
    {
        $this->articleContract = $articleContract;

        $this->reactionContract =$reactionContract;

        $this->request = Request::capture();
    }

    public function view(Request $request): View
    {


        $article = $this->articleContract->getArticleById($request->id);

        $reactions =  $this->reactionContract->getReactions($request->id);

//        dd($reactions);


        if ($article === null) {
            abort(404, "Article not found");
        }

        return view('pages.article-view', [
            'article' => $article,
            'reactions' => $reactions
        ]);


    }
}
