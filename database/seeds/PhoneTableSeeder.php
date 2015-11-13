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
            $p = explode('x', $faker->unique()->phoneNumber);
            $number = intval('1' . trim(str_replace('-', '', $p[1])));
            $ext = intval($p[1]);

            Phone::create([
                'user_id' => $faker->randomElement($userIds),
                'number' => $number,
                'ext' => $ext
            ]);

        }
    }
}
