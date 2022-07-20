<?php

namespace App\Resources;

use App\Models\ArticleTags;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $image
 * @property string $author
 * @property mixed $category
 * @property mixed $tags
 * @property mixed $feed
 * @property mixed $info
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
            'text' => strip_tags($this->content),
            'excerpt' => Str::words(strip_tags($this->content), 15),
            'link' => $this->link,
            'image' => $this->image,
            'published_at' => Carbon()->parse($this->published_at)->format('d m y H:i:s'),
            'category' => $this->formatCategory($this->category),
            'feed' => $this->feed,
            'author' => $this->author,
            'url'=> url('articles/' . $this->id . '/' . Str::slug($this->title)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }


    private function formatCategory(Category $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'count' => $category->count,
            'url' => url('categories/' . $category->id . '/' . Str::slug($category->name)),
        ];
    }

    private function getImages(Collection $articleTags): array
    {
        $images = collect();

        $articleTags->each(function (Tag $tag) use ($images) {

            $search = Http::get('https://www.bing.com/images/search?q='.$tag->name.'&qs=MM&form=QBIR&sp=2&pq=raspberry&sk=MM1&sc=8-9&cvid=3A8B8D8A6BC44248BD8EB60FAB99B4E1&first=1&tsc=ImageHoverTitle');

            $content =  ($search->body());
            $crawler = new Crawler($content);

            $images->push ($crawler->filter('img.mimg')->each(function (Crawler $node) {
                return $node->attr('src');
            }));

        });

        return $images->flatten()->toArray();

    }

}
