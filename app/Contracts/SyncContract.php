<?php

namespace App\Contracts;

use App\Models\Feed;

Interface SyncContract
{
    public function syncSingle(Feed $feed): void;
    public function syncAll(): void;
}
