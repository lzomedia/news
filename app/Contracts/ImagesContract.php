<?php
namespace App\Contracts;

use Illuminate\Support\Collection;

interface ImagesContract
{
    public function getImages(string $query):Collection;
}
