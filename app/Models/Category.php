<?php namespace App\Models;



use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @mixin EloquentBuilder
 * @mixin QueryBuilder
 * @property int $id
 * @property string $name
 * @property int $count
 */
class Category extends BaseModel
{

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
