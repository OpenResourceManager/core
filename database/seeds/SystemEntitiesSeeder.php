<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Duty;
use App\Http\Models\API\Country;
use App\Http\Models\API\State;
use App\Http\Models\API\MobileCarrier;
use Illuminate\Database\Eloquent\Model;
use Krucas\Settings\Facades\Settings;


class SystemEntitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Country::insert(countryList());
        State::insert(stateList());
        MobileCarrier::insert(mobileCarrierList());
        Duty::insert(defaultDuties());

        Settings::set('enable-registration', false);
        Settings::set('excluded-email-domains', []);

        Model::reguard();
    }
}
