<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Record\Phone;
use App\Model\Record\User;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 8:39 PM
 */
class PhoneTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $faker = Faker::create();

        $userIds = User::get()->lists('id')->all();

        foreach (range(1, 500) as $index) {
            Phone::create([
                'user_id' => $faker->randomElement($userIds),
                'number' => $faker->unique()->randomNumber($nbDigits = 11, $strict = true),
                'ext' => $faker->optional()->randomNumber($nbDigits = 5)
            ]);

        }
    }
}
