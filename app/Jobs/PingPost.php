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

    protected Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function handle(): bool
    {
        return (new \Garf\LaravelPinger\Pinger)->pingAll(
            $this->article->title,
            url(''). 'articles/'.$this->article->id.'/'.Str::slug($this->article->title),
        );
    }
}
