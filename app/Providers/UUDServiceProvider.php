<?php

namespace App\Providers;

use App\Model\User;
use Illuminate\Support\ServiceProvider;

class UUDServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::creating(function (User $user) {
            // Ensure that a user's name is always formatted correctly
            $user->format_full_name();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
