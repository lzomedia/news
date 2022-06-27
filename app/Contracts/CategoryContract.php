<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CategoryContract
{
    public function getAllCategories(): Collection;
}
