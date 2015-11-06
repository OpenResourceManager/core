<?php

namespace App\Providers;

use App\Model\Building;
use App\Model\Campus;
use App\Model\Department;
use App\Model\Program;
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
        // set deleting event for building. Should delete all children rooms.
        Building::deleting(function ($building) {
            $building->rooms()->delete();
        });

        // set deleting event for campus. Should delete all children buildings.
        Campus::deleting(function ($campus) {
            foreach ($campus->rooms() as $room) {
                $room->delete();
            }
            $campus->buildings()->delete();
        });

        User::deleting(function ($user) {
            $user->emails()->delete();
            $user->phones()->delete();
            $user->rooms()->delete();
        });

        Program::deleting(function ($program) {
            $program->courses()->delete();
        });

        Department::deleting(function ($department) {
            foreach ($department->courses() as $course) {
                $course->delete();
            }
            $department->programs()->delete();
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
