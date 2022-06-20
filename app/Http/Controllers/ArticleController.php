<?php

namespace App\Http\Controllers;


use App\Contracts\ArticleDatabaseContract;
use App\Contracts\FeedDatabaseContract;

use App\Http\Controllers\Api\ArticlesApiController;
use App\Parsers\OpmlParser;
use App\Requests\SaveFileRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    private ArticleDatabaseContract $articleDatabaseContract;

    public function __construct(
        ArticleDatabaseContract $articleDatabaseContract
    )
    {
        $this->articleDatabaseContract = $articleDatabaseContract;
    }


    public function index(): JsonResponse
    {
        return view('articles.index');
    }



    public function indexApi(): JsonResponse
    {

        return response()->json(
            $this->articleDatabaseContract->getAllArticles()
        );
    }

}
