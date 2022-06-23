<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait UserErrorTrait
{
    public function checkUserIsAuthenticated(): void
    {
        if (Auth::guest()) {
            abort(401, 'You are not authorized to access this page.');
        }
    }
}
