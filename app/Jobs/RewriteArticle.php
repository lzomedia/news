<?php

namespace App\Jobs;

use App\Contracts\TextRewriterContract;
use App\Models\Article;
use App\Models\Feed;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class RewriteArticle implements ShouldQueue
{
    use Dispatchable;

    use InteractsWithQueue;

    use Queueable;

    use SerializesModels;

    public TextRewriterContract $textContract;

    public Article | Model $article;

    public function __construct(TextRewriterContract $textContract, Article $article)
    {
        $this->textContract = $textContract;
        $this->article = $article;
    }

    public function handle(): void
    {
        $this->textContract->rewrite($this->article);
    }

    public function failed(): void
    {
        $this->delete();
    }
}
