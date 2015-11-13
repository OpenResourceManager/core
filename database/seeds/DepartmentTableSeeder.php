<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Department;
use Faker\Generator as Faker;

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

        $faker = new Faker;

        $faker->addProvider(new Faker\Provider\en_US\Company($faker));

        foreach (range(1, 150) as $index) {
            Department::create([
                'academic' => $faker->boolean(40),
                'code' => $faker->unique()->text(3),
                'name' => $faker->unique()->catchPhrase,
            ]);
        }
    }
}
