<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ArticleResource extends JsonResource
{
    public function toArray($request): array
    {
        return $this->resource->toArray();
    }
}
