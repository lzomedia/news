<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\VideoContract;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class VideoGenerator extends Controller
{
    private VideoContract $videoContract;

    public function __construct(VideoContract $videoContract)
    {
        $this->videoContract = $videoContract;
    }

    public function generate(Article $article): View
    {
        return view('dashboard.video-generate', [
            'article' => $article,
        ]);
    }

    public function upload(Article $article): void
    {
        Log::info('Uploading video for article: ' . $article->id);
    }
}
