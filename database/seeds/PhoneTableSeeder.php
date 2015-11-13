<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Phone;
use App\Model\User;
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

        foreach (range(1, 1000) as $index) {

            $number = $faker->randomElement([
                intval(1 . $faker->randomNumber(3, true) . $faker->unique()->randomNumber(7)),
                intval(1518 . $faker->randomElement([244, 292]))
            ]);

            if ($number === 1518244 || $number === 1518292) {
                $ext = $faker->unique()->randomNumber(4, true);
                $number = $number . $ext;
                $cell = false;
            } else {
                $ext = $faker->optional()->randomNumber(4);
                $cell = $faker->boolean();
            }

            if ($cell) {
                $carrier = $faker->randomElement([
                    'T-Mobile',
                    'Sprint',
                    'AT&T',
                    'Verizon',
                    'Boost Mobile',
                    'Cricket Wireless',
                    'Straight Talk',
                    'Vodaphone',
                    'Virgin Mobile',
                    'MetroPCS',
                    'TracPhone',
                    'Other'
                ]);
            } else {
                $carrier = null;
            }

            Phone::create([
                'user_id' => $faker->randomElement($userIds),
                'number' => $number,
                'ext' => $ext,
                'is_cell' => $cell,
                'carrier' => $carrier
            ]);
        }
    }
}
