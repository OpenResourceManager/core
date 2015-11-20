<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Role;
use App\Model\Community;
use Faker\Factory as Faker;

class RoleCommunityTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $faker = Faker::create();

        $roleIds = Role::lists('id')->all();
        $communityIds = Community::lists('id')->all();

        foreach (range(1, 3) as $index) {
            DB::table('community_role')->insert([
                'community_id' => $faker->randomElement($communityIds),
                'role_id' => $faker->unique()->randomElement($roleIds)
            ]);
        }
    }
}
