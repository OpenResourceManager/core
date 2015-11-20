<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Course;
use App\Model\Community;
use Faker\Factory as Faker;

class CourseCommunityTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $faker = Faker::create();

        $courseIds = Course::lists('id')->all();
        $communityIds = Community::lists('id')->all();

        foreach (range(1, 205) as $index) {
            DB::table('role_course')->insert([
                'community_id' => $faker->randomElement($communityIds),
                'course_id' => $faker->unique()->randomElement($courseIds)
            ]);
        }
    }
}
