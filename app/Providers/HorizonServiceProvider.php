<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();
        Horizon::night();
    }

    protected function gate(): void
    {
        Gate::define(
            'viewHorizon',
            static function ($user) {
                return $user->email === Config::get('config.admin_email');
            }
        );
    }
}
