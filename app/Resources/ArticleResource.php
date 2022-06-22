<?php

namespace App\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**

 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $image
 * @property string $author
 * @property mixed $category
 * @property mixed $feed
 * @property string $link
 * @property Carbon $published_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
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
            'url'=> url('articles/' . $this->id . '/' . Str::slug($this->title)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }


}
