<?php

namespace App\Repositories;

use App\Contracts\ArticleContract;
use App\DTO\Article as ArticleDTO;
use App\Models\Article;
use App\Models\ArticleInfo;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleRepository implements ArticleContract
{
    public function getArticleById(mixed $articleId): ?Model
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

    //todo implement here the creation of the seo model
    public function createArticle(ArticleDTO $articleDTO): Model
    {
        $articleModel =  (new Article())->updateOrCreate(
            [
                'feed_id' => $articleDTO->getFeedId(),
                'category_id' => ($articleDTO->getCategory())->id,
                'title' => $articleDTO->getTitle(),
                'image' => $articleDTO->getImage(),
                'content' => $articleDTO->getContent(),
                'summary' => $articleDTO->getSummary(),
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
        return Article::where('source', $articleDTO->getSource())->exists();
    }
}
