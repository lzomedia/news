<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @mixin    EloquentBuilder
 * @mixin    QueryBuilder
 * @property int $id
 * @property string $name
 * @property int $count
 * @method static create(array $array)
 * @method static where(string $string, $value)
 * @method static updateOrCreate(array $array)
 * @method static whereIn(string $string, array $array)
 * @method static firstOrCreate(array $array)
 * @method static whereNotIn(string $string, array $array)
 * @method static first()
 *
 */
class Category extends BaseModel
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'count',
    ];
    protected $dates = [
        'sync',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
