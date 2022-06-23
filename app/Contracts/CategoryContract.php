<?php

namespace App\Contracts;

use App\Resources\ArticleResourceCollection;

use Illuminate\Database\Eloquent\Model;
use App\DTO\Article as ArticleDTO;
use \Illuminate\Database\Eloquent\Collection;

interface CategoryContract
{
    public function getAllCategories(): Collection;
}
