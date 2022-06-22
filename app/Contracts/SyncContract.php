<?php

namespace App\Contracts;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Contracts\Auth\Authenticatable;



Interface SyncContract
{
    public function syncSingle(Feed | Model $feed, User|Authenticatable $user): bool;

    public function syncAll(User | Authenticatable $user): bool;
}
