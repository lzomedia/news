<?php

namespace App\Repositories;

use App\Contracts\ArticleDatabaseContract;
use App\Models\Article;
use App\Resources\ArticleResourceCollection;


class ArticleRepository implements ArticleDatabaseContract
{
    public function getArticleById(int $articleId): Article
    {
       return Article::with('category')
           ->with('tags')
           ->with('info')
           ->find($articleId);
    }

    public function getAllArticles(): ArticleResourceCollection
    {
        return new ArticleResourceCollection(
            Article::with('category')
                ->with('feed')
                ->orderBy('id', 'desc')
                ->paginate(10)
        );
    }

    public function createArticle(array $data): Article
    {
        return (new \App\Models\Article)->firstOrCreate($data);
    }
}
