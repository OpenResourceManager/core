<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Course;
use App\Model\Department;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 11:06 AM
 */
class CourseTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $faker = Faker::create();

        $deptIds = Department::where('academic', true)->lists('id')->all();

        foreach (range(1, 300) as $index) {
            Course::create([
                'department_id' => $faker->randomElement($deptIds),
                'code' => $faker->unique()->text(7) . $faker->randomNumber(3, true),
                'course_level' => $faker->randomElement([100, 200, 300, 400, 500]),
                'name' => $faker->unique()->sentence
            ]);
        }
    }
}
