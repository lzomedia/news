<?php namespace App\Models;


use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @mixin EloquentBuilder
 * @mixin QueryBuilder
 * @property int $id
 * @property string $title
 * @property string $url
 * @property Carbon $sync
 */
class Feed extends Model
{

    const INITIAL =  'initial';

    const SYNCYING =  'synchronizing';

    const COMPLETED = 'completed';


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
