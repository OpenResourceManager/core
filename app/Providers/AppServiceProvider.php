<?php

namespace App\Providers;

use App\Model\Building;
use App\Model\Campus;
use App\Model\Room;
use App\Model\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // set deleting event for campus. Should delete all children buildings.
        Campus::deleting(function ($campus) {
            $campus->buildings()->delete();
        });

        // set deleting event for building. Should delete all children rooms.
        Building::deleting(function ($building) {
            $building->rooms()->delete();
        });

        User::deleting(function ($user) {
            $user->emails()->delete();
            $user->phones()->delete();
            $user->password()->delete();
            $user->addresses()->delete();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        }
    }
}
