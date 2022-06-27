<?php

namespace App\Services;

use App\Contracts\TextRewriterContract;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class TextRewriterManager implements TextRewriterContract
{
    public function rewrite(Article | Model $article): void
    {
        try {

            $content = strip_tags($article->content);

            $process = new Process(
                [
                    "python3" ,
                    base_path("./python/text-rewriter.py"),
                    '"'.$content.'"',
                ]
            );

            $process->setTimeout(3600);
            $process->run();
            if (!$process->isSuccessful()) {
                throw new \RuntimeException($process->getErrorOutput());
            }

            Log::info("Text Rewriter: ".$process->getOutput());

            $article->content = $process->getOutput();
            $article->save();

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
