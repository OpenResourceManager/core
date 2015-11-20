<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Campus;
use App\Model\Community;
use Faker\Factory as Faker;

class CampusCommunityTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $faker = Faker::create();

        $campusIds = Campus::lists('id')->all();
        $communityIds = Community::lists('id')->all();

        foreach (range(1, 2) as $index) {
            DB::table('role_campus')->insert([
                'community_id' => $faker->randomElement($communityIds),
                'campus_id' => $faker->unique()->randomElement($campusIds)
            ]);
        }
    }
}
