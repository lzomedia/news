<?php

namespace App\Repositories;

use App\Models\User;
use App\Contracts\UserContract;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserContract
{
    public function getAllUsers(): array
    {
        return User::all()->toArray();
    }

    public function getUserId(): int
    {
        return Auth::id();
    }

    public function getUser(): \Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::user();
    }
}
