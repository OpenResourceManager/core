<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Http\Models\API\Account;
use App\Events\Api\Account\AccountCreated;
use App\Events\Api\Account\AccountUpdated;
use App\Events\Api\Account\AccountDeleted;
use App\Events\Api\Account\AccountRestored;


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
            event(new AccountDeleted($account));
        });

        Account::restored(function (Account $account) {
            event(new AccountRestored($account));
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
