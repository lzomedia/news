<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

interface UserContract
{
    public function getAllUsers(): array;

    public function getUserId(): int;

    public function getUser(): User | Authenticatable;
}
