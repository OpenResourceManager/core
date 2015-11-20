<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\User;
use App\Model\Community;
use Faker\Factory as Faker;

class UserCommunityTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $faker = Faker::create();

        $userIds = User::lists('id')->all();
        $communityIds = Community::lists('id')->all();

        foreach (range(1, 85) as $index) {
            DB::table('community_user')->insert([
                'community_id' => $faker->randomElement($communityIds),
                'user_id' => $faker->unique()->randomElement($userIds)
            ]);
        }
    }
}
