<?php

namespace App\Services;

use App\Models\Category;
use Flobbos\Crudable\Contracts\Crud;
use Flobbos\Crudable;

class CategoryService implements Crud {

    use Crudable\Crudable;

    public function __construct(Category $category) {
        $this->model = $category;
    }

}
