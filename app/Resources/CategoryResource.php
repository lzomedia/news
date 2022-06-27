<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

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
        Log::info('CategoryResource::toArray' . $request->url());

        return [
            'data' => $this->resource->toArray()
        ];
    }
}
