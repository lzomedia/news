<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
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
 * @method updateOrCreate(array $array)
 */
class Article extends Model
{
    use HasSEO;

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

    public function info(): BelongsTo
    {
        return $this->belongsTo(ArticleInfo::class);
    }


    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getFeedId(): int
    {
        return $this->feed_id;
    }


    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            $this->title,
            $this->content,
            $this->image,
            $this->author,
            $this->published_at,
            SchemaCollection::initialize()->addArticle()
        );
    }
}
