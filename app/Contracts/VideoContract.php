<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface VideoContract
{
    public function find(string $query):Collection;
    public function generate(mixed $article): void;
}
