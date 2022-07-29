<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface CategoryContract
{
    public function getAllCategories(): Builder;
    public function getCategoryById(int $id): Builder;
    public function delete(int $id): int;
    public function getCategoryByName(string $name): Builder;
}
