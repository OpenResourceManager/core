<?php

namespace App\Providers;

use App\Events\Api\Building\BuildingCreated;
use App\Events\Api\Building\BuildingDestroyed;
use App\Events\Api\Building\BuildingRestored;
use App\Events\Api\Building\BuildingUpdated;
use App\Events\Api\Campus\CampusUpdated;
use App\Events\Api\Campus\CampusCreated;
use App\Events\Api\Campus\CampusDestroyed;
use App\Events\Api\Campus\CampusRestored;
use App\Events\Api\Course\CourseCreated;
use App\Events\Api\Course\CourseDestroyed;
use App\Events\Api\Course\CourseRestored;
use App\Events\Api\Course\CourseUpdated;
use App\Events\Api\Department\DepartmentCreated;
use App\Events\Api\Department\DepartmentDestroyed;
use App\Events\Api\Department\DepartmentRestored;
use App\Events\Api\Department\DepartmentUpdated;
use App\Events\Api\Duty\DutyDestroyed;
use App\Events\Api\Duty\DutyRestored;
use App\Events\Api\Duty\DutyUpdated;
use App\Events\Api\Room\RoomCreated;
use App\Events\Api\Room\RoomDestroyed;
use App\Events\Api\Room\RoomRestored;
use App\Events\Api\Room\RoomUpdated;
use App\Events\Api\ServiceAccount\ServiceAccountCreated;
use App\Events\Api\ServiceAccount\ServiceAccountDestroyed;
use App\Events\Api\ServiceAccount\ServiceAccountRestored;
use App\Events\Api\ServiceAccount\ServiceAccountUpdated;
use App\Http\Models\API\AliasAccount;
use App\Http\Models\API\Building;
use App\Http\Models\API\Campus;
use App\Http\Models\API\Course;
use App\Http\Models\API\Department;
use App\Http\Models\API\Duty;
use App\Http\Models\API\Room;
use function foo\func;
use Illuminate\Support\ServiceProvider;
use App\Http\Models\API\Account;
use App\Events\Api\Account\AccountCreated;
use App\Events\Api\Account\AccountUpdated;
use App\Events\Api\Account\AccountDestroyed;
use App\Events\Api\Account\AccountRestored;
use App\Events\Api\Duty\DutyCreated;
use App\Events\Api\AliasAccount\AliasAccountCreated;
use App\Events\Api\AliasAccount\AliasAccountUpdated;
use App\Events\Api\AliasAccount\AliasAccountRestored;
use App\Events\Api\AliasAccount\AliasAccountDestroyed;
use App\Http\Models\API\ServiceAccount;
use App\Http\Models\API\LoadStatus;
use App\Events\Api\LoadStatus\LoadStatusCreated;
use App\Events\Api\LoadStatus\LoadStatusDestroyed;
use App\Events\Api\LoadStatus\LoadStatusRestored;
use App\Events\Api\LoadStatus\LoadStatusUpdated;

class ApiEventProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Account Events
         */
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

        /**
         * Alias Account Events
         */
        AliasAccount::created(function (AliasAccount $account) {
            event(new AliasAccountCreated($account));
        });

        AliasAccount::updated(function (AliasAccount $account) {
            event(new AliasAccountUpdated($account));
        });

        AliasAccount::deleted(function (AliasAccount $account) {
            event(new AliasAccountDestroyed($account));
        });

        AliasAccount::restored(function (AliasAccount $account) {
            event(new AliasAccountRestored($account));
        });

        /**
         * Service Account Events
         */
        ServiceAccount::created(function (ServiceAccount $account) {
            event(new ServiceAccountCreated($account));
        });

        ServiceAccount::updated(function (ServiceAccount $account) {
            event(new ServiceAccountUpdated($account));
        });

        ServiceAccount::deleted(function (ServiceAccount $account) {
            event(new ServiceAccountDestroyed($account));
        });

        ServiceAccount::restored(function (ServiceAccount $account) {
            event(new ServiceAccountRestored($account));
        });

        /**
         * Building Events
         */
        Building::created(function (Building $building) {
            event(new BuildingCreated($building));
        });

        Building::updated(function (Building $building) {
            event(new BuildingUpdated($building));
        });

        Building::restored(function (Building $building) {
            event(new BuildingRestored($building));
        });

        Building::deleted(function (Building $building) {
            event(new BuildingDestroyed($building));
        });

        /**
         * Campus Events
         */
        Campus::created(function (Campus $campus) {
            event(new CampusCreated($campus));
        });

        Campus::restored(function (Campus $campus) {
            event(new CampusRestored($campus));
        });

        Campus::updated(function (Campus $campus) {
            event(new CampusUpdated($campus));
        });

        Campus::deleted(function (Campus $campus) {
            event(new CampusDestroyed($campus));
        });

        /**
         * Course Events
         */
        Course::created(function (Course $course) {
            event(new CourseCreated($course));
        });

        Course::deleted(function (Course $course) {
            event(new CourseDestroyed($course));
        });

        Course::updated(function (Course $course) {
            event(new CourseUpdated($course));
        });

        Course::restored(function (Course $course) {
            event(new CourseRestored($course));
        });

        /**
         * Department Events
         */
        Department::created(function (Department $department) {
            event(new DepartmentCreated($department));
        });

        Department::deleted(function (Department $department) {
            event(new DepartmentDestroyed($department));
        });

        Department::restored(function (Department $department) {
            event(new DepartmentRestored($department));
        });

        Department::updated(function (Department $department) {
            event(new DepartmentUpdated($department));
        });

        /**
         * Duty Events
         */
        Duty::created(function (Duty $duty) {
            event(new DutyCreated($duty));
        });

        Duty::restored(function (Duty $duty) {
            event(new DutyRestored($duty));
        });

        Duty::updated(function (Duty $duty) {
            event(new DutyUpdated($duty));
        });

        Duty::deleted(function (Duty $duty) {
            event(new DutyDestroyed($duty));
        });

        /**
         * Room Events
         */
        Room::created(function (Room $room) {
            event(new RoomCreated($room));
        });

        Room::deleted(function (Room $room) {
            event(new RoomDestroyed($room));
        });

        Room::updated(function (Room $room) {
            event(new RoomUpdated($room));
        });

        Room::restored(function (Room $room) {
            event(new RoomRestored($room));
        });

        /**
         * LoadStatus Events
         */
        LoadStatus::created(function (LoadStatus $ls) {
            event(new LoadStatusCreated($ls));
        });

        LoadStatus::deleted(function (LoadStatus $ls) {
            event(new LoadStatusDestroyed($ls));
        });

        LoadStatus::updated(function (LoadStatus $ls) {
            event(new LoadStatusUpdated($ls));
        });

        LoadStatus::restored(function (LoadStatus $ls) {
            event(new LoadStatusRestored($ls));
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
