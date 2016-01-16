<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 6:00 PM
 */

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use App\Model\State;
use App\Model\User;
use App\Model\Address;

class AddressTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $faker = Faker::create();

        $states = State::get()->all();
        $users = User::get()->all();

        foreach (range(1, 400) as $index) {

            $user = $faker->randomElement($users);
            $state = $faker->randomElement($states);
            $name_prefix = ($user->name_prefix) ? $user->name_prefix : '';
            $name_middle = ($user->name_middle) ? $user->name_middle : '';
            $name_postfix = ($user->name_postfix) ? $user->name_postfix : '';
            $addressee = $faker->boolean() ? $name_prefix . ' ' . $user->name_first . ' ' . $name_middle . ' ' . $user->name_last . ' ' . $name_postfix : null;
            $lat_long = [[$faker->randomFloat(), $faker->randomFloat()], [$faker->randomFloat(), $faker->randomFloat()]];
            $latlng_pick = $faker->optional()->randomElement($lat_long);
            $lat = (is_null($latlng_pick)) ? null : $latlng_pick[0];
            $lng = (is_null($latlng_pick)) ? null : $latlng_pick[1];

            Address::Create([
                'user_id' => $user->id,
                'addressee' => $addressee,
                'organization' => $faker->optional()->company,
                'line_1' => $faker->address,
                'line_2' => $faker->optional()->word,
                'city' => $faker->city,
                'state_id' => $state->id,
                'zip' => $faker->randomNumber($nbDigits = 11, $strict = true),
                'country_id' => $state->country_id,
                'latitude' => $lat,
                'longitude' => $lng
            ]);
        }
    }
}
