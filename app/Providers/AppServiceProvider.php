<?php

namespace App\Providers;

use App\Model\Building;
use App\Model\Campus;
use App\Model\Course;
use App\Model\Department;
use App\Model\Room;
use App\Model\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;
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

        // Adds a user campus record when a user is assigned a room.
        Room::created(function ($room) {
            $user_id = $room->user_id;
            $building = Building::find($room->building_id);
            $campus_id = $building->campus_id;

            $user = User::findOrFail($user_id);
            $campus = Campus::findOrFail($campus_id);

            if (!$user->campuses->contains($campus->id)) {
                $user->attach($campus);
            }

            /* if (!DB::table('campus_user')->where('campus_id', $campus_id)->where('user_id', $user_id)->first()) {
                 DB::table('campus_user')->insert(['campus_id' => $campus_id, 'user_id' => $user_id]);
             } */
        });

        // set deleting event for campus. Should delete all children buildings.
        Campus::deleting(function ($campus) {
            foreach ($campus->rooms() as $room) {
                $room->delete();
            }
            $campus->buildings()->delete();
        });

        Pivot::created(function ($pivot) {
            if ($pivot->getTable() == 'course_user') {
                $course = Course::findOrFail($pivot->course_id);
                $user = User::findOrFail($pivot->user_id);
                $department = Department::findOrFail($course->department_id);
                if (!$user->departments->contains($department->id)) {
                    $user->attach($department);
                }
            }
        });

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
