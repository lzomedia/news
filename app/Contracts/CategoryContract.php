<?php

namespace App\Contracts;

use Flobbos\Crudable\Contracts\Crud;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface CategoryContract extends Crud
{
    public function getAllCategories(): Builder;
}
