<?php

namespace App\Http\Controllers;

use App\Contracts\VideoContract;
use App\Models\Article;

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
        //todo upload video to a hosting service
    }
}
