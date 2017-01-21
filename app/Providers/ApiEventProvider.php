<?php

namespace App\Providers;

use App\Events\Api\Building\BuildingCreated;
use App\Events\Api\Building\BuildingDestroyed;
use App\Events\Api\Campus\CampusCreated;
use App\Events\Api\Campus\CampusDestroyed;
use App\Events\Api\Course\CourseCreated;
use App\Events\Api\Course\CourseDestroyed;
use App\Events\Api\Department\DepartmentCreated;
use App\Events\Api\Department\DepartmentDestroyed;
use App\Events\Api\Duty\DutyDestroyed;
use App\Events\Api\Room\RoomCreated;
use App\Events\Api\Room\RoomDestroyed;
use App\Http\Models\API\Building;
use App\Http\Models\API\Campus;
use App\Http\Models\API\Course;
use App\Http\Models\API\Department;
use App\Http\Models\API\Duty;
use App\Http\Models\API\Room;
use Illuminate\Support\ServiceProvider;
use App\Http\Models\API\Account;
use App\Events\Api\Account\AccountCreated;
use App\Events\Api\Account\AccountUpdated;
use App\Events\Api\Account\AccountDestroyed;
use App\Events\Api\Account\AccountRestored;
use App\Events\Api\Duty\DutyCreated;

class ApiEventProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Account::created(function (Account $account) {
            event(new AccountCreated($account));
        });

        Account::updated(function (Account $account) {
            event(new AccountUpdated($account));
        });

        Account::deleted(function (Account $account) {
            event(new AccountDestroyed($account));
        });

        Account::restored(function (Account $account) {
            event(new AccountRestored($account));
        });

        Duty::created(function (Duty $duty) {
            event(new DutyCreated($duty));
        });

        Duty::deleted(function (Duty $duty) {
            event(new DutyDestroyed($duty));
        });

        Campus::created(function (Campus $campus) {
            event(new CampusCreated($campus));
        });

        Campus::deleted(function (Campus $campus) {
            event(new CampusDestroyed($campus));
        });

        Building::created(function (Building $building) {
            event(new BuildingCreated($building));
        });

        Building::deleted(function (Building $building) {
            event(new BuildingDestroyed($building));
        });

        Room::created(function (Room $room) {
            event(new RoomCreated($room));
        });

        Room::deleted(function (Room $room) {
            event(new RoomDestroyed($room));
        });

        Department::created(function (Department $department) {
            event(new DepartmentCreated($department));
        });

        Department::deleted(function (Department $department) {
            event(new DepartmentDestroyed($department));
        });

        Course::created(function (Course $course) {
            event(new CourseCreated($course));
        });

        Course::deleted(function (Course $course) {
            event(new CourseDestroyed($course));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
