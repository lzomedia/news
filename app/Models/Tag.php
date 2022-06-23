<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @mixin    EloquentBuilder
 * @mixin    QueryBuilder
 * @property string $name
 */
class Tag extends BaseModel
{
    protected $table = 'tags';

    protected $fillable = [
        'name',
    ];
}
