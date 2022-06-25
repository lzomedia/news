<?php

namespace App\Repositories;

use App\Contracts\ArticleContract;
use App\DTO\Article as ArticleDTO;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use JsonException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleContract
{
    public function getArticleById(mixed $articleId): Model
    {
        return Article::with('category')
            ->with('tags')
            ->with('info')
            ->find($articleId);
    }

    public function getAllArticles(): LengthAwarePaginator
    {
        return Article::with('category')
            ->with('tags')
            ->with('info')
            ->orderBy('created_at', 'desc')
            ->paginate(25);
    }

    public function createArticle(\App\DTO\Article $articleDTO): Model
    {
        try {
            $articleModel =  (new \App\Models\Article())->updateOrCreate(
                [
                'feed_id' => $articleDTO->getFeedId(),
                'category_id' => $articleDTO->getCategory()->id,
                'title' => $articleDTO->getTitle(),
                'image' => $articleDTO->getImage(),
                'content' => $articleDTO->getContent(),
                'author' => $articleDTO->getAuthors(),
                'source' => $articleDTO->getSource(),
                ]
            );

            $articleModel->category()->increment('count');

            foreach ($articleDTO->getKeywords() as $tag) {
                $articleModel->tags()->attach(
                    (new \App\Models\Tag())->firstOrCreate(['name' => $tag])
                );
            }

            (new \App\Models\ArticleInfo())->firstOrCreate(
                [
                'article_id' => $articleModel->id,
                'time_to_read' => $articleDTO->getTimeToRead(),
                'vader' => json_encode($articleDTO->getVader(), JSON_THROW_ON_ERROR),
                ]
            );

            return $articleModel;

        } catch (QueryException $exception) {
            Log::error($exception->getTraceAsString());
        } catch (JsonException $e) {
            Log::error($e->getTraceAsString());
        }

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
