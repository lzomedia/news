<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\DTO\Article as ArticleDTO;
use Illuminate\Database\Eloquent\Builder;

interface ArticleContract
{
    /**
     * This will return an article.
     * @param mixed $articleId
     * @return Model|null
     */
    public function getArticleById(mixed $articleId): ?Model;

    public function getAllArticles(): Builder;

    public function createArticle(ArticleDTO $articleDTO): Model;

    public function checkIfArticleExists(ArticleDTO $articleDTO): bool;

}
