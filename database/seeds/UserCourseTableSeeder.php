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

        foreach (range(1, 150) as $index) {
            $user = User::find($faker->unique()->randomElement($userIds));
            $user->courses()->attach($faker->randomElement($courseIds));
        }
    }

}