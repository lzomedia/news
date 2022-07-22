<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\ImageMeta;
use RalphJSmit\Laravel\SEO\Support\SEOData;

/**
 * @mixin    EloquentBuilder
 * @mixin    QueryBuilder
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $summary
 * @property string $image
 * @property string $author
 * @property int $category_id
 * @property int $feed_id
 * @method   firstOrCreate(array $array)
 * @method   static where(string $string, $value)
 * @method   static find(int $id)
 * @method updateOrCreate(array $array)
 */
class Article extends Model
{
    use HasSEO;

    use HasFactory;

    protected $table = 'articles';

    protected $fillable = [
        'title',
        'content',
        'summary',
        'feed_id',
        'category_id',
        'pubDate',
        'author',
        'image',
        'source',
        'feed_id',
        'published_at',
    ];

    public function feed(): BelongsTo
    {
        return $this->belongsTo(Feed::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reactions(): BelongsTo
    {
        return $this->belongsTo(ArticleReactions::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getFeedId(): int
    {
        return $this->feed_id;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }


    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            $this->title,
            $this->summary,
            $this->author,
            $this->image,
            $this->getUrl(),
            true,
            $this->imageMeta(),
        );
    }


    private function getUrl(): string
    {
        return route('articles.show', $this->id);
    }

    private function imageMeta()
    {
        if ( $this->image ) {
            return new ImageMeta($this->image);
        }

        return $this->image;
    }
}
