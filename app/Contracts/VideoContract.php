<?php

namespace App\Contracts;

use App\Models\Article;

interface VideoContract
{
    public function generateVideo(Article $article): void;
}
