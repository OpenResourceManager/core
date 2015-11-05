<?php

namespace App\Providers;

use App\Building;
use App\Campus;
use App\Room;
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
        Building::deleting(function (Building $building) {
            $rooms = $building->rooms();
            foreach ($rooms as $room) {
                $room->delete();
            }
        });

        // set deleting event for campus. Should delete all children buildings.
        Campus::deleting(function (Campus $campus) {
            $buildings = $campus->buildings();
            foreach ($buildings as $building) {
                $building->delete();
            }
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
