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

        foreach (range(1, 150) as $index) {
            Department::create([
                'academic' => $faker->boolean(40),
                'code' => $faker->unique()->text(3),
                'name' => $faker->unique()->company,
            ]);
        }
    }
}
