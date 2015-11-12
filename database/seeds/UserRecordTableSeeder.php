<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Record\User_Record;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 9:38 AM
 */
class UserRecordTableSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();

        $faker = Faker::create();

        foreach (range(1, 5000) as $index) {
            User_Record::create([
                'sageid' => $faker->unique()->randomNumber($nbDigits = 7, $strict = true),
                'active' => $faker->boolean(),
                'name_prefix' => $faker->optional()->title,
                'name_first' => $faker->firstName,
                'name_middle' => $faker->optional()->firstName,
                'name_last' => $faker->lastName,
                'name_postfix' => $faker->optional()->title,
                'name_phonetic' => $faker->optional()->firstName,
                'username' => $faker->unique()->userName
            ]);
        }
    }
}
