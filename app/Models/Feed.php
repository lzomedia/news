<?php

namespace App\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @mixin Builder
 * @mixin QueryBuilder
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $url
 * @property Carbon $sync
 * @property string $status
 * @method static orderBy(string $string)
* @method static where(string $string, $value)
 * @method static find($id)
 * @method static create(array $array)
 */
class Feed extends BaseModel
{
    public const INITIAL =  'initial';

    public const SYNCYING =  'synchronizing';

    public const COMPLETED = 'completed';

    public const FAILED = 'failed';


    protected $table = 'feeds';

    protected $fillable = [
        'user_id',
        'title',
        'url',
        'sync'
    ];
    protected $dates = [
        'sync',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
