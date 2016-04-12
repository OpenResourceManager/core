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
use App\Model\PivotAction;
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
            $course_id = $faker->randomElement($courseIds);
            PivotAction::create(['id_1' => $course_id, 'id_2' => $user->id, 'class_1' => 'course', 'class_2' => 'user', 'assign' => true]);
            $user->courses()->attach($course_id);
        }
    }

}