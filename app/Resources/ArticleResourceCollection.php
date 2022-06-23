<?php

namespace App\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class ArticleResourceCollection extends ResourceCollection
{
    public function toArray($request): Collection
    {
        $articles =  $this->collection->map(function (ArticleResource $article) {
            return new ArticleResource($article);
        });

        $categories = (new Category())->orderBy('count', 'desc')->limit(10)->get();

        return collect([
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }
}
