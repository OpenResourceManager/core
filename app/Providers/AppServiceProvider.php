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
        // Adds a user campus record when a user is assigned a room.
        Room::created(function ($room) {
            foreach ($room->users()->get() as $user) {
                $building = Building::find($room->building_id);
                $campus_id = $building->campus_id;

                $user = User::findOrFail($user->id);
                $campus = Campus::findOrFail($campus_id);

                if (!$user->campuses->contains($campus->id)) {
                    $user->campuses()->attach($campus);
                }
            }
        });

        // set deleting event for campus. Should delete all children buildings.
        Campus::deleting(function ($campus) {
            $campus->buildings()->delete();
        });

        // set deleting event for building. Should delete all children rooms.
        Building::deleting(function ($building) {
            $building->rooms()->delete();
        });

        // Adds a user campus record when a user is assigned a room.
        /* Room::deleting(function ($room) {
            $user_id = $room->user_id;
            $building = Building::find($room->building_id);
            $campus_id = $building->campus_id;

            $user = User::findOrFail($user_id);
            $campus = Campus::findOrFail($campus_id);

            if (!$user->campuses->contains($campus->id)) {
                $user->campuses()->detach($campus);
            }
        }); */

        User::deleting(function ($user) {
            $user->emails()->delete();
            $user->phones()->delete();
            $user->rooms()->delete();
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
