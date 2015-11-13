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

            $ext = null;
            $number = $faker->randomElement([
                intval(1518 . $faker->unique()->randomNumber(7)),
                intval(1518 . $faker->randomElement([244, 292]))
            ]);

            if ($number == 1518244 || 1518292) {
                $ext = $faker->unique()->randomNumber(4);
                $number = $number . $ext;
            }

            Phone::create([
                'user_id' => $faker->randomElement($userIds),
                'number' => $number,
                'ext' => $ext
            ]);
        }
    }
}
