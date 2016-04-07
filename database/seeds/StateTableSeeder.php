<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 8:15 PM
 */

use App\Model\State;
use App\Model\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class StateTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $usa_id = Country::where('code', 'USA')->first()->id;
        $can_id = Country::where('code', 'CAN')->first()->id;

        $states = [
            array('name' => 'Alabama', 'code' => 'AL', 'country_id' => $usa_id),
            array('name' => 'Alaska', 'code' => 'AK', 'country_id' => $usa_id),
            array('name' => 'Arizona', 'code' => 'AZ', 'country_id' => $usa_id),
            array('name' => 'Arkansas', 'code' => 'AR', 'country_id' => $usa_id),
            array('name' => 'California', 'code' => 'CA', 'country_id' => $usa_id),
            array('name' => 'Colorado', 'code' => 'CO', 'country_id' => $usa_id),
            array('name' => 'Connecticut', 'code' => 'CT', 'country_id' => $usa_id),
            array('name' => 'Delaware', 'code' => 'DE', 'country_id' => $usa_id),
            array('name' => 'District of Columbia', 'code' => 'DC', 'country_id' => $usa_id),
            array('name' => 'Florida', 'code' => 'FL', 'country_id' => $usa_id),
            array('name' => 'Georgia', 'code' => 'GA', 'country_id' => $usa_id),
            array('name' => 'Hawaii', 'code' => 'HI', 'country_id' => $usa_id),
            array('name' => 'Idaho', 'code' => 'ID', 'country_id' => $usa_id),
            array('name' => 'Illinois', 'code' => 'IL', 'country_id' => $usa_id),
            array('name' => 'Indiana', 'code' => 'IN', 'country_id' => $usa_id),
            array('name' => 'Iowa', 'code' => 'IA', 'country_id' => $usa_id),
            array('name' => 'Kansas', 'code' => 'KS', 'country_id' => $usa_id),
            array('name' => 'Kentucky', 'code' => 'KY', 'country_id' => $usa_id),
            array('name' => 'Louisiana', 'code' => 'LA', 'country_id' => $usa_id),
            array('name' => 'Maine', 'code' => 'ME', 'country_id' => $usa_id),
            array('name' => 'Maryland', 'code' => 'MD', 'country_id' => $usa_id),
            array('name' => 'Massachusetts', 'code' => 'MA', 'country_id' => $usa_id),
            array('name' => 'Michigan', 'code' => 'MI', 'country_id' => $usa_id),
            array('name' => 'Minnesota', 'code' => 'MN', 'country_id' => $usa_id),
            array('name' => 'Mississippi', 'code' => 'MS', 'country_id' => $usa_id),
            array('name' => 'Missouri', 'code' => 'MO', 'country_id' => $usa_id),
            array('name' => 'Montana', 'code' => 'MT', 'country_id' => $usa_id),
            array('name' => 'Nebraska', 'code' => 'NE', 'country_id' => $usa_id),
            array('name' => 'Nevada', 'code' => 'NV', 'country_id' => $usa_id),
            array('name' => 'New Hampshire', 'code' => 'NH', 'country_id' => $usa_id),
            array('name' => 'New Jersey', 'code' => 'NJ', 'country_id' => $usa_id),
            array('name' => 'New Mexico', 'code' => 'NM', 'country_id' => $usa_id),
            array('name' => 'New York', 'code' => 'NY', 'country_id' => $usa_id),
            array('name' => 'North Carolina', 'code' => 'NC', 'country_id' => $usa_id),
            array('name' => 'North Dakota', 'code' => 'ND', 'country_id' => $usa_id),
            array('name' => 'Ohio', 'code' => 'OH', 'country_id' => $usa_id),
            array('name' => 'Oklahoma', 'code' => 'OK', 'country_id' => $usa_id),
            array('name' => 'Oregon', 'code' => 'OR', 'country_id' => $usa_id),
            array('name' => 'Pennsylvania', 'code' => 'PA', 'country_id' => $usa_id),
            array('name' => 'Puerto Rico', 'code' => 'PR', 'country_id' => $usa_id),
            array('name' => 'Rhode Island', 'code' => 'RI', 'country_id' => $usa_id),
            array('name' => 'South Carolina', 'code' => 'SC', 'country_id' => $usa_id),
            array('name' => 'South Dakota', 'code' => 'SD', 'country_id' => $usa_id),
            array('name' => 'Tennessee', 'code' => 'TN', 'country_id' => $usa_id),
            array('name' => 'Texas', 'code' => 'TX', 'country_id' => $usa_id),
            array('name' => 'Utah', 'code' => 'UT', 'country_id' => $usa_id),
            array('name' => 'Vermont', 'code' => 'VT', 'country_id' => $usa_id),
            array('name' => 'Virginia', 'code' => 'VA', 'country_id' => $usa_id),
            array('name' => 'Washington', 'code' => 'WA', 'country_id' => $usa_id),
            array('name' => 'West Virginia', 'code' => 'WV', 'country_id' => $usa_id),
            array('name' => 'Wisconsin', 'code' => 'WI', 'country_id' => $usa_id),
            array('name' => 'Wyoming', 'code' => 'WY', 'country_id' => $usa_id),
            // Canada
            array('name' => 'Alberta', 'code' => 'AB', 'country_id' => $can_id),
            array('name' => 'British Columbia', 'code' => 'BC', 'country_id' => $can_id),
            array('name' => 'Manitoba', 'code' => 'MB', 'country_id' => $can_id),
            array('name' => 'New Brunswick', 'code' => 'NB', 'country_id' => $can_id),
            array('name' => 'Newfoundland', 'code' => 'NF', 'country_id' => $can_id),
            array('name' => 'Northwest Territories', 'code' => 'NT', 'country_id' => $can_id),
            array('name' => 'Nova Scotia', 'code' => 'NS', 'country_id' => $can_id),
            array('name' => 'Nunavut', 'code' => 'NU', 'country_id' => $can_id),
            array('name' => 'Ontario', 'code' => 'ON', 'country_id' => $can_id),
            array('name' => 'Prince Edward Island', 'code' => 'PE', 'country_id' => $can_id),
            array('name' => 'Quebec', 'code' => 'PQ', 'country_id' => $can_id),
            array('name' => 'Saskatchewan', 'code' => 'SK', 'country_id' => $can_id),
            array('name' => 'Yukon', 'code' => 'YT', 'country_id' => $can_id)
        ];
        foreach ($states as $state) {
            State::create($state);
        }
    }

}