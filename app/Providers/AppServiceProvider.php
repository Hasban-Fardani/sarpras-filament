<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // if (env('APP_ENV', 'local') == 'production') {
        //     URL::forceScheme('https');
        // }

        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('supervisor', function ($user) {
            return $user->role === 'supervisor';
        });

        Gate::define('division', function ($user) {
            return $user->role === 'division';
        });
    }
}
