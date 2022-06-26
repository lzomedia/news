<?php

namespace App\Contracts;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;

interface TextRewriterContract
{
    public function rewrite(Article | Model $article): void;
}
