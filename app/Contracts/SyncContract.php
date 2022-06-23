<?php

namespace App\Contracts;

interface SyncContract
{
    public function syncSingle(int $feed_id, int $article_id): bool;

    public function syncAll(UserContract $userContract): bool;
}
