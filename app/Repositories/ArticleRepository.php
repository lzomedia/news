<?php

namespace App\Repositories;

use App\Contracts\ArticleContract;
use App\DTO\Article as ArticleDTO;
use App\Models\Article;
use App\Models\ArticleInfo;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use JsonException;
use Illuminate\Database\Eloquent\Builder;

class ArticleRepository implements ArticleContract
{
    public function getArticleById(mixed $articleId): Model
    {
        return Article::with('category')
            ->with('tags')
            ->with('info')
            ->find($articleId);
    }

    public function getAllArticles(): Builder
    {
        return Article::with('category')
            ->with('tags')
            ->with('feed')
            ->with('info')
            ->orderBy('created_at', 'desc');
    }

    public function createArticle(ArticleDTO $articleDTO): Model
    {
        $articleModel =  (new Article())->updateOrCreate(
            [
                'feed_id' => $articleDTO->getFeedId(),
                'category_id' => ($articleDTO->getCategory())->id,
                'title' => $articleDTO->getTitle(),
                'image' => $articleDTO->getImage(),
                'content' => $articleDTO->getContent(),
                'author' => $articleDTO->getAuthors(),
                'source' => $articleDTO->getSource(),
            ]
        );
        /** @var Article $articleModel */

        $articleModel->category()->increment('count');

        foreach ($articleDTO->getKeywords() as $tag) {
            $articleModel->tags()->attach(
                (new Tag())->firstOrCreate(['name' => $tag])
            );
        }

        (new ArticleInfo())->firstOrCreate(
            [
                'article_id' => $articleModel->id,
                'time_to_read' => $articleDTO->getTimeToRead(),
                'vader' => json_encode($articleDTO->getVader(), JSON_THROW_ON_ERROR),
            ]
        );

        return $articleModel;
    }

    public function checkIfArticleExists(ArticleDTO $articleDTO): bool
    {
        $article = Article::where('feed_id', $articleDTO->getFeedId())
            ->where('title', $articleDTO->getTitle())
            ->first();
        if (is_null($article)) {
            return false;
        }
        return true;
    }
}
