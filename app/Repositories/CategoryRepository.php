<?php

namespace App\Repositories;

use App\Contracts\CategoryContract;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Flobbos\Crudable\Contracts\Crud;
use Flobbos\Crudable;

class CategoryRepository implements CategoryContract
{
    use Crudable\Crudable;


    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function getAllCategories(): Collection
    {
        return Category::with('articles')->orderBy('count', 'desc')->get();
    }
}
