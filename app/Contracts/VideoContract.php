<?php

namespace App\Contracts;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;

interface VideoContract
{
    public function generateVideo(Article $article): void;
}
