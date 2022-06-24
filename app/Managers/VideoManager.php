<?php

namespace App\Managers;

use App\Contracts\VideoContract;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\InputStream;
use Symfony\Component\Process\Process;

class VideoManager implements VideoContract
{
    private const PYTHON = 'python3';

    private const PYTHON_FILE_EXTRACT_REALTIME = './python/video-generator.py';

    public function generateVideo(Article | Model $article): void
    {
        try {

            $process = new Process(
                [
                    "tts",
                    "--text",
                    strip_tags($article->content),
                ]
            );
            $process->setTimeout(3600);


            $process->run(
                function ($type, $buffer) {
                    Log::error("Output: $buffer");
                }
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
