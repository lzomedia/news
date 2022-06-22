<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class VideoGenerator extends Controller
{
    public function generateVideo(Article $article): void
    {
        dd($article);
    }
}
