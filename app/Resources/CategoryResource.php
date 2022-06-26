<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**

 * @property int $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'data' => $this->resource->toArray()
        ];
    }
}
