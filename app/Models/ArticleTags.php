<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @mixin EloquentBuilder
 * @mixin QueryBuilder
 */
class ArticleTags extends Model
{
    protected $table = 'article_tag';

    protected $fillable = [
        'tag_id',
        'article_id',
    ];

    public $timestamps = false;
}

