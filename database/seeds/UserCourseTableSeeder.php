<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/17/15
 * Time: 8:06 PM
 */

use Illuminate\Database\Seeder;
use App\Model\Course;
use App\Model\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserCourseTableSeeder extends Seeder
{
    public function run()
    {

        $faker = Faker::create();
        $userIds = User::lists('id')->all();
        $courseIds = Course::lists('id')->all();

        foreach (range(1, 700) as $index) {
            DB::table('course_user')->insert([
                'course_id' => $faker->randomElement($courseIds),
                'user_id' => $faker->unique()->randomElement($userIds)
            ]);
        }
    }

}