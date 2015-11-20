<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\User;
use App\Model\Role;
use Faker\Factory as Faker;

class UserRoleTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $faker = Faker::create();

        $userIds = User::lists('id')->all();
        $roleIds = Role::lists('id')->all();

        foreach (range(1, 150) as $index) {
            DB::table('role_user')->insert([
                'role_id' => $faker->randomElement($roleIds),
                'user_id' => $faker->unique()->randomElement($userIds)
            ]);
        }
    }
}
