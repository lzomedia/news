<?php

namespace App\Contracts;

use App\Models\Feed;

Interface SyncContract
{
    public function syncSingle(Feed $feed): bool;
    public function syncAll(): bool;
}
