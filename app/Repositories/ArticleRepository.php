<?php

namespace App\Repositories;

use App\Contracts\ArticleContract;
use App\DTO\Article as ArticleDTO;
use App\Jobs\PingPost;
use App\Models\Article;
use App\Models\ArticleReactions;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use JsonException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Query\Builder as DatabaseBuilder;

class ArticleRepository implements ArticleContract
{
    public function getArticleById(mixed $articleId): ?Model
    {
        return Article::with('category')
            ->with('tags')
            ->with('reactions')
            ->find($articleId);
    }

    public function getAllArticles(): Builder
    {
        return Article::with('category')
            ->with('tags')
            ->with('feed')
            ->with('reactions')
            ->orderBy('created_at', 'desc');
    }

    /**
     * @throws JsonException
     * @throws \Exception
     */
    public function createArticle(ArticleDTO $articleDTO): Model
    {

        $wordCount = Str::wordCount($articleDTO->content);

        if ($wordCount < 100) {
            throw new \Exception('Article must contain at least 100 words');
        }

        $articleModel = (new Article())->updateOrCreate(
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

        (new ArticleReactions())->firstOrCreate(
            [
                'article_id' => $articleModel->id,
                'time_to_read' => $articleDTO->getTimeToRead(),
                'vader' => json_encode($articleDTO->getVader(), JSON_THROW_ON_ERROR),
            ]
        );

        try{
            dispatch(new PingPost($articleModel))->delay(now()->addSeconds(random_int(1, 10)));
        }catch (\Exception $e){
            throw new \Exception('Ping Exception: '.$e->getMessage());
        }

        return $articleModel;
    }

    public function checkIfArticleExists(ArticleDTO $articleDTO): bool
    {
        return Article::where('source', $articleDTO->getSource())->exists();
    }

    /**
     * @throws JsonException
     */
    public function getTopArticles(): Collection
    {

        $articlesReactions = ArticleReactions::orderBy('created_at')->get();

        $collection = collect();

        foreach ($articlesReactions as $articlesReaction) {

            $data = collect(json_decode($articlesReaction->vader, false, 512, JSON_THROW_ON_ERROR));

            if ($data["compound"] > 0.95) {
                $collection->push(
                    collect([
                        'article_id' => $articlesReaction->article_id,
                        'compound' => $data["compound"],
                        'created_at' => $articlesReaction->created_at,
                    ])
                );
            }
        }

        $collection = (collect($collection->toArray())->sortByDesc('compound'));

        $articles = collect();
        Cache::forget('top_articles');
        foreach ($collection as $item) {
            $articles->push(
                Article::with('category')
                    ->with('tags')
                    ->with('feed')
                    ->with('reactions')
                    ->find($item['article_id'])
            );
        }
        Cache::remember('top_articles', now()->addMinutes(5), static function () use ($articles) {
            return $articles;
        });
        return ($articles);
    }

    public function getArticleByTag(string $tag): ?Model
    {
        return Article::with('tags')
            ->whereHas('tags', function (Builder $query) use ($tag) {
                $query->where('name', $tag);
            })
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
