<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Course;

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

        // Create an array of courses
        $courses = array(
            array('SPAN101', 'Spanish 101', 2),
            array('FREN101', 'French 101', 2),
            array('GERM101', 'German 101', 2),
            array('ENGL101', 'English 101', 2)
        );

        // Loop through the array then save the data to the database
        foreach ($courses as $courseArr) {
            $course = new Course();
            $course->code = $courseArr[0];
            $course->name = $courseArr[1];
            $course->program_id = $courseArr[2];
            $course->save();
        }
    }

}