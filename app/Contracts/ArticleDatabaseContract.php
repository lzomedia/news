<?php

namespace App\Contracts;

use App\Resources\ArticleResourceCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\DTO\Article as ArticleDTO;

interface ArticleDatabaseContract
{
    public function getArticleById(int $articleId): Model;

    public function getAllArticles(): ArticleResourceCollection;

    public function createArticle(ArticleDTO $articleDTO): Model;
}
