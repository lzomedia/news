<?php

namespace App\Repositories;

use App\Contracts\ReactionContract;
use App\Models\Article;
use App\Models\ArticleReactions;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\DTO\Reactions;

class ReactionsRepository implements ReactionContract
{
    /**
     * @throws UnknownProperties
     */
    public function getReactions(string $articleId): Reactions
    {

        $reactions = ArticleReactions::where('article_id', $articleId)->get()->first();

        return new Reactions($reactions->toArray());
    }
}
