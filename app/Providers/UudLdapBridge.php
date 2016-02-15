<?php

namespace App\Providers;

use App\Model\Address;
use App\Model\Apikey;
use App\Model\Building;
use App\Model\Campus;
use App\Model\Country;
use App\Model\Course;
use App\Model\Department;
use App\Model\Email;
use App\Model\MobileCarrier;
use App\Model\Phone;
use App\Model\Role;
use App\Model\Room;
use App\Model\State;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use App\Model\User;

class UudLdapBridge extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Address::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
        });

        Apikey::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
        });

        Building::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
        });

        Campus::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
        });

        Country::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
        });

        Course::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
        });

        Department::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
        });

        Email::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
        });

        MobileCarrier::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
        });

        Phone::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
        });

        Role::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
        });

        Room::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
        });

        State::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
        });

        User::created(function ($object) {
            Log::info(get_class($object) . ': ' . $object->id . ' was created.');
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
