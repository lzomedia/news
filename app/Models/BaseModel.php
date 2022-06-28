<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $url
 * @property Carbon $sync
 * @property string $status
 */
abstract class BaseModel extends Model
{
}
