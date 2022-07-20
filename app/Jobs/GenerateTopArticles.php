<?php

namespace App\Jobs;

use App\Contracts\ArticleContract;
use App\DTO\Article as ArticleDTO;


use App\Models\ArticleReactions;
use App\Repositories\FeedRepository;
use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class GenerateTopArticles implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public string $message = "Some message";

    public ArticleContract $articleContract;


    public function __construct(ArticleContract $articleContract)
    {
        $this->articleContract = $articleContract;
    }

    final public function handle(): void
    {
        $topArticles = $this->articleContract->getTopArticles();

        foreach ($topArticles as $article)
        {
            //insert into top articles
        }
    }

    public function failed(): void
    {
        $this->delete();
    }
}
