<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Record\Email;
use App\Model\Record\User;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 8:38 PM
 */
class EmailTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $faker = Faker::create();
        $userIds = User::get()->lists('id')->all();

        foreach (range(1, 1000) as $index) {
            Email::create([
                'user_id' => $faker->randomElement($userIds),
                'email' => $faker->unique()->email
            ]);
        }
    }
}