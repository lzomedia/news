<?php
namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;


class CategoryResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'categories' => $this->collection->map(function (CategoryResource $category) {
                return new CategoryResource($category);
            })
        ];
    }
}
