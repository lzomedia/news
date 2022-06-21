<?php

namespace App\Contracts;

use App\Models\Feed;
use Illuminate\Database\Eloquent\Model;

Interface SyncContract
{
    public function syncSingle(Feed | Model $feed): bool;
    public function syncAll(): bool;
}
