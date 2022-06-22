<?php

namespace App\Contracts;

use App\Models\Article;
use Illuminate\Support\Collection;

interface VideoGeneratorContract
{
    public function generateVideo(): void;

    public function getVideosForArticle(int $article_id): Collection;

}
