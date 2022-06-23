<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryResourceCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => $this->collection->map(
                function ($item) {
                    return new CategoryResource($item);
                }
            )
        ];
    }
}
