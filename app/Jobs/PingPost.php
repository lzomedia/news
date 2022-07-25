<?php

namespace App\Jobs;

use App\Contracts\ArticleContract;
use App\Models\Article;
use Garf\LaravelPinger\Pinger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class PingPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ArticleContract $article;

    protected int $articleId;

    public function __construct(ArticleContract $article, int $articleId)
    {
        $this->article = $article;

        $this->articleId = $articleId;
    }

    public function handle(): void
    {
        /** @var Article $article */
        $article = $this->article->getArticleById($this->articleId);

        if ($article !== null) {
            $ping = new Pinger();
            $ping->pingAll(
                $article->title,
                url(''). 'articles/'.$article->id.'/'.Str::slug($article->title),
            );
        }



    }
}
