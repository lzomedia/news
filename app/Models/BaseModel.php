<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon $sync
 * @property string $status
 */
abstract class BaseModel extends Model
{
}
