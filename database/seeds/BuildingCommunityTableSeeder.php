<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Building;
use App\Model\Community;
use Faker\Factory as Faker;

class BuildingCommunityTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $faker = Faker::create();

        $buildingIds = Building::lists('id')->all();
        $communityIds = Community::lists('id')->all();

        foreach (range(1, 100) as $index) {
            DB::table('building_community')->insert([
                'community_id' => $faker->randomElement($communityIds),
                'building_id' => $faker->unique()->randomElement($buildingIds)
            ]);
        }
    }
}
