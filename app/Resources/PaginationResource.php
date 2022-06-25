<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginationResource extends ResourceCollection
{

    public function toArray($request):array
    {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => $this->resource->nextPageUrl(),
                'next' => $this->resource->nextPageUrl(),
                'prev' => $this->resource->previousPageUrl(),
            ],
        ];
    }

}
