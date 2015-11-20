<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Department;
use App\Model\Community;
use Faker\Factory as Faker;

class DepartmentCommunityTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $faker = Faker::create();

        $departmentIds = Department::lists('id')->all();
        $communityIds = Community::lists('id')->all();

        foreach (range(1, 50) as $index) {
            DB::table('community_department')->insert([
                'community_id' => $faker->randomElement($communityIds),
                'department_id' => $faker->unique()->randomElement($departmentIds)
            ]);
        }
    }
}
