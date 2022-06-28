<?php

namespace App\Services;

use App\Contracts\VideoContract;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class VideoManager implements VideoContract
{
    private const TTS = 'python3';

    private const OPTION = '--text';

    public function generateVideo(mixed $article): void
    {
        try {
            $process = new Process(
                [
                    self::TTS,
                    self::OPTION,
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
