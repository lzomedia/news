<?php

namespace App\Contracts;

use Illuminate\Support\Collection;
use App\Models\Article;

interface ArticleDatabaseContract
{
    public function getArticleById(int $articleId): Article;

    public function getAllArticles();

    public function createArticle(array $data): Article;
}
