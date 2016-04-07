<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 8:15 PM
 */

use App\Model\State;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class StateTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $states = [
            array('name' => 'Alabama', 'code' => 'AL', 'country_id' => 226),
            array('name' => 'Alaska', 'code' => 'AK', 'country_id' => 226),
            array('name' => 'Arizona', 'code' => 'AZ', 'country_id' => 226),
            array('name' => 'Arkansas', 'code' => 'AR', 'country_id' => 226),
            array('name' => 'California', 'code' => 'CA', 'country_id' => 226),
            array('name' => 'Colorado', 'code' => 'CO', 'country_id' => 226),
            array('name' => 'Connecticut', 'code' => 'CT', 'country_id' => 226),
            array('name' => 'Delaware', 'code' => 'DE', 'country_id' => 226),
            array('name' => 'District of Columbia', 'code' => 'DC', 'country_id' => 226),
            array('name' => 'Florida', 'code' => 'FL', 'country_id' => 226),
            array('name' => 'Georgia', 'code' => 'GA', 'country_id' => 226),
            array('name' => 'Hawaii', 'code' => 'HI', 'country_id' => 226),
            array('name' => 'Idaho', 'code' => 'ID', 'country_id' => 226),
            array('name' => 'Illinois', 'code' => 'IL', 'country_id' => 226),
            array('name' => 'Indiana', 'code' => 'IN', 'country_id' => 226),
            array('name' => 'Iowa', 'code' => 'IA', 'country_id' => 226),
            array('name' => 'Kansas', 'code' => 'KS', 'country_id' => 226),
            array('name' => 'Kentucky', 'code' => 'KY', 'country_id' => 226),
            array('name' => 'Louisiana', 'code' => 'LA', 'country_id' => 226),
            array('name' => 'Maine', 'code' => 'ME', 'country_id' => 226),
            array('name' => 'Maryland', 'code' => 'MD', 'country_id' => 226),
            array('name' => 'Massachusetts', 'code' => 'MA', 'country_id' => 226),
            array('name' => 'Michigan', 'code' => 'MI', 'country_id' => 226),
            array('name' => 'Minnesota', 'code' => 'MN', 'country_id' => 226),
            array('name' => 'Mississippi', 'code' => 'MS', 'country_id' => 226),
            array('name' => 'Missouri', 'code' => 'MO', 'country_id' => 226),
            array('name' => 'Montana', 'code' => 'MT', 'country_id' => 226),
            array('name' => 'Nebraska', 'code' => 'NE', 'country_id' => 226),
            array('name' => 'Nevada', 'code' => 'NV', 'country_id' => 226),
            array('name' => 'New Hampshire', 'code' => 'NH', 'country_id' => 226),
            array('name' => 'New Jersey', 'code' => 'NJ', 'country_id' => 226),
            array('name' => 'New Mexico', 'code' => 'NM', 'country_id' => 226),
            array('name' => 'New York', 'code' => 'NY', 'country_id' => 226),
            array('name' => 'North Carolina', 'code' => 'NC', 'country_id' => 226),
            array('name' => 'North Dakota', 'code' => 'ND', 'country_id' => 226),
            array('name' => 'Ohio', 'code' => 'OH', 'country_id' => 226),
            array('name' => 'Oklahoma', 'code' => 'OK', 'country_id' => 226),
            array('name' => 'Oregon', 'code' => 'OR', 'country_id' => 226),
            array('name' => 'Pennsylvania', 'code' => 'PA', 'country_id' => 226),
            array('name' => 'Puerto Rico', 'code' => 'PR', 'country_id' => 226),
            array('name' => 'Rhode Island', 'code' => 'RI', 'country_id' => 226),
            array('name' => 'South Carolina', 'code' => 'SC', 'country_id' => 226),
            array('name' => 'South Dakota', 'code' => 'SD', 'country_id' => 226),
            array('name' => 'Tennessee', 'code' => 'TN', 'country_id' => 226),
            array('name' => 'Texas', 'code' => 'TX', 'country_id' => 226),
            array('name' => 'Utah', 'code' => 'UT', 'country_id' => 226),
            array('name' => 'Vermont', 'code' => 'VT', 'country_id' => 226),
            array('name' => 'Virginia', 'code' => 'VA', 'country_id' => 226),
            array('name' => 'Washington', 'code' => 'WA', 'country_id' => 226),
            array('name' => 'West Virginia', 'code' => 'WV', 'country_id' => 226),
            array('name' => 'Wisconsin', 'code' => 'WI', 'country_id' => 226),
            array('name' => 'Wyoming', 'code' => 'WY', 'country_id' => 226),
            // Canada
/*            array('name' => 'Alberta', 'code' => 'AB', 'country_id' => 38),
            array('name' => 'British Columbia', 'code' => 'BC', 'country_id' => 38),
            array('name' => 'Manitoba', 'code' => 'MB', 'country_id' => 38),
            array('name' => 'New Brunswick', 'code' => 'NB', 'country_id' => 38),
            array('name' => 'Newfoundland', 'code' => 'NF', 'country_id' => 38),
            array('name' => 'Northwest Territories', 'code' => 'NT', 'country_id' => 38),
            array('name' => 'Nova Scotia', 'code' => 'NS', 'country_id' => 38),
            array('name' => 'Nunavut', 'code' => 'NU', 'country_id' => 38),
            array('name' => 'Ontario', 'code' => 'ON', 'country_id' => 38),
            array('name' => 'Prince Edward Island', 'code' => 'PE', 'country_id' => 38),
            array('name' => 'Quebec', 'code' => 'PQ', 'country_id' => 38),
            array('name' => 'Saskatchewan', 'code' => 'SK', 'country_id' => 38),
            array('name' => 'Yukon', 'code' => 'YT', 'country_id' => 38)*/
        ];
        foreach ($states as $state) {
            State::create($state);
        }
    }

}