<?php

namespace App\Repositories;

use App\Models\User;
use App\Contracts\UserContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

class UserRepository implements UserContract
{
    public function getAllUsers(): array
    {
        return User::all()->toArray();
    }

    public function getUserId(): int|string|null
    {
        return Auth::id();
    }

    public function getUser(): ?Authenticatable
    {
        return Auth::user();
    }
}
