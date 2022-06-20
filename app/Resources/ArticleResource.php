<?php

namespace App\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ArticleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => Str::words(strip_tags($this->content), 15),
            'link' => $this->link,
            'image' => $this->image,
            'published_at' => $this->published_at,
            'category' => $this->category,
            'feed' => $this->feed,
            'author' => $this->author,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
