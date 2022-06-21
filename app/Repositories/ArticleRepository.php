<?php

namespace App\Repositories;

use App\Contracts\ArticleDatabaseContract;
use App\DTO\Article as ArticleDTO;
use App\Models\Article;
use App\Models\Article as ArticleModel;
use App\Models\Category;
use App\Resources\ArticleResourceCollection;
use Illuminate\Database\Eloquent\Model;

class ArticleRepository implements ArticleDatabaseContract
{
    public function getArticleById(int $articleId): Model
    {
       return Article::with('category')
           ->with('tags')
           ->with('info')
           ->find($articleId);
    }

    public function getAllArticles(): ArticleResourceCollection
    {
        return new ArticleResourceCollection(
            Article::with('category')
                ->with('feed')
                ->orderBy('id', 'desc')
                ->paginate(10)
        );
    }

    /**
     * @throws \JsonException
     */
    public function createArticle(\App\DTO\Article $articleDTO): Model
    {

        $category = (new \App\Models\Category())->firstOrCreate([
            'name' => $articleDTO->getCategory()
        ]);

        $articleModel =  (new \App\Models\Article)->firstOrCreate([
            'title' => $articleDTO->getTitle(),
            'feed_id' => $articleDTO->getFeedId(),
            'category_id' => $category->get('id'),
            'image' => $articleDTO->getImage(),
            'author' => $articleDTO->getAuthors(),
            'source' => $articleDTO->getSource(),
            'content' => $articleDTO->getContent(),
            'published_at' => $articleDTO->getDate(),
        ]);

        $articleModel->category()->increment('count');

        foreach ($articleDTO->getKeywords() as $tag) {
            $articleModel->tags()->attach(
                (new \App\Models\Tag)->firstOrCreate(['name' => $tag])
            );
        }

        (new \App\Models\ArticleInfo)->firstOrCreate([
            'article_id' => $articleModel->get('id'),
            'time_to_read' => $articleDTO->getTimetoread(),
            'vader' => json_encode($articleDTO->getVader(), JSON_THROW_ON_ERROR),
        ]);

        return $articleModel;
    }

}
