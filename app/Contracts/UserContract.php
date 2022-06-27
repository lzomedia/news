<?php

namespace App\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface UserContract
{
    public function getAllUsers(): array;

    public function getUserId(): int|string|null;

    public function getUser(): ?Authenticatable;
}
