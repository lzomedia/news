<?php

namespace App\Contracts;

interface SyncContract
{
    public function syncSingle(int $feedID, int $articleID): bool;

    public function syncAll(UserContract $userContract): bool;
}
