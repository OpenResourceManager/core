<?php

namespace App\Providers;

use App\Building;
use App\Campus;
use App\Room;
use Illuminate\Support\Facades\Log;
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
        // set deleting event for building. Should delete all children rooms.
        Building::deleting(function ($building) {
            $building->rooms()->delete();
        });

        // set deleting event for campus. Should delete all children buildings.
        Campus::deleting(function ($campus) {
            $campus->rooms();
            $campus->buildings()->delete();
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
