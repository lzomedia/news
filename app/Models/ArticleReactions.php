<?php

namespace App\Models;

/**
 * @property int $article_id
 * @property string $time_to_read
 * @method   firstOrCreate(array $array)
 * @method   static where(array $array)
 * @method   static groupBy(array $array)
 */
class ArticleReactions extends BaseModel
{
    protected $table = 'article_reactions';

    protected $fillable = [
        'article_id',
        'time_to_read',
        'vader',
    ];

    protected $casts = [
        'vader' => 'array'
    ];

}
