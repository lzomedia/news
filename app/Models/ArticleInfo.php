<?php

namespace App\Models;

/**
 * @property int $article_id
 * @property string $time_to_read
 * @method firstOrCreate(array $array)
 */
class ArticleInfo extends BaseModel
{
    protected $table = 'article_info';

    protected $fillable = [
        'article_id',
        'time_to_read',
        'vader',
    ];

    protected $casts = [
        'vader' => 'array'
    ];
}
