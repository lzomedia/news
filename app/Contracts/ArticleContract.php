<?php

namespace App\Contracts;

use App\Resources\ArticleResourceCollection;
use Illuminate\Database\Eloquent\Model;
use App\DTO\Article as ArticleDTO;

interface ArticleContract
{
    public function getArticleById(mixed $articleId): Model;

    public function getAllArticles(): ArticleResourceCollection;

    public function createArticle(ArticleDTO $articleDTO): Model;

    public function checkIfArticleExists(ArticleDTO $articleDTO): bool;

}
