<?php

namespace App\Http\Controllers;

use App\Contracts\VideoContract;
use App\Models\Article;
use Illuminate\Support\Facades\Log;

class VideoGenerator extends Controller
{
    private VideoContract $videoContract;

    public function __construct(VideoContract $videoContract)
    {
        $this->videoContract = $videoContract;
    }

    public function generate(Article $article): void
    {
        $this->videoContract->generateVideo($article);
    }

    public function upload(Article $article): void
    {
        Log::info('Uploading video for article: ' . $article->id);
    }
}
