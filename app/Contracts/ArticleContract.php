<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\DTO\Article as ArticleDTO;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleContract
{
    public function getArticleById(mixed $articleId): Model;

    public function getAllArticles(): LengthAwarePaginator;

    public function createArticle(ArticleDTO $articleDTO): Model;

    public function checkIfArticleExists(ArticleDTO $articleDTO): bool;

}
