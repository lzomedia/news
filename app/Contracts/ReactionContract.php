<?php

namespace App\Contracts;

use App\DTO\Reactions;
use Illuminate\Database\Eloquent\Model;
use App\DTO\Article as ArticleDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface ReactionContract
{
    public function getReactions(string $articleId): Reactions;
}
