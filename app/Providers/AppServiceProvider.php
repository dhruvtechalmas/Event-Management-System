<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Lottery;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;
use Laravel\Pennant\Feature;

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
        Schema::defaultStringLength(191);

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        // // Define the feature flag
        // Feature::define('new-dashboard', function (User $user) {
        //     return $user->name === 'Dhruv';
        // });

        //  Feature::define('new-dashboard', Lottery::odds(1,10));

        //  Feature::define('theme',function (User $user){
        //     return Arr::random([
        //         'dark',
        //         'light',
        //         'mono'
        //     ]);
        //  });

       

    }
}
