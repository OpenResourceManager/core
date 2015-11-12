<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use App\Model\Campus;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:36 AM
 */
class CampusTableSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();

        $faker = Faker::create();

        foreach (range(1, 5) as $index) {
            $city = $faker->city;
            Campus::create([
                'code' => strtoupper(substr($city, 3)),
                'name' => $city
            ]);

        }

    }

}