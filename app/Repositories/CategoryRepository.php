<?php

namespace App\Repositories;

use App\Contracts\CategoryContract;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryContract
{

    public function getAllCategories(): Builder
    {
        return Category::with('articles')->orderBy('count', 'desc');
    }

    public function getCategoryById(int $id): Builder
    {
        return Category::with('articles')->where('id', $id);
    }

    public function delete(int $id): int
    {
        return Category::where('id', $id)->delete();
    }

    public function getCategoryByName(string $name): Builder
    {
        return Category::where('name', $name);
    }

}
