<?php

namespace App\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
/**

 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $url
 * @property string $status
 * @property Carbon $sync
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class FeedResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'sync' => $this->sync,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

}
