<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Department;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 11:06 AM
 */
class DepartmentTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $faker = Faker::create();

        foreach (range(1, 100) as $index) {

            $names = [
                $faker->word . ' ' . $faker->word,
                $faker->word . ' ' . $faker->word . $faker->word . ' ' . $faker->word,
                implode(' ', $faker->words) . ' ' . $faker->word,
            ];

            Department::create([
                'academic' => $faker->boolean(40),
                'code' => $faker->unique()->text(7),
                'name' => $faker->unique()->randomElement($names),
            ]);
        }
    }
}
