<?php

namespace App\Repositories;

use App\Contracts\CategoryContract;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Flobbos\Crudable\Contracts\Crud;
use Flobbos\Crudable;

class CategoryRepository implements CategoryContract
{


    public function getAllCategories(): Builder
    {
        return Category::with('articles')->orderBy('count', 'desc');
    }
}
