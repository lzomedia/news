<?php

namespace App\Repositories;

use App\Contracts\CategoryContract;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryContract
{
    public function getAllCategories(): Collection
    {
        return Category::all();
    }
}
