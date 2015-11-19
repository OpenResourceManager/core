<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use App\Model\Community;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 11:06 AM
 */
class CommunityTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $faker = Faker::create();

        foreach (range(1, 40) as $index) {
            Community::create([
                'code' => $faker->unique()->word,
                'name' => $faker->sentence($nbWords = 3)
            ]);
        }
    }
}