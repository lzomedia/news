<?php

namespace App\Contracts;

use App\Resources\ArticleResourceCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\DTO\Article as ArticleDTO;

interface ArticleDatabaseContract
{
    public function getArticleById(mixed $articleId): Model;

    //todo implement here a  way to select just the user articles
    public function getAllArticles(): ArticleResourceCollection;

    public function createArticle(ArticleDTO $articleDTO): Model;
}
