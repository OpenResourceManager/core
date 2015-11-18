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

        foreach (range(1, 200) as $index) {
            $pair = $faker->unique()->randomElement([
                [$faker->randomElement($roleIds), $faker->randomElement($userIds)],
                [$faker->randomElement($roleIds), $faker->randomElement($userIds)]
            ]);

            DB::table('role_user')->insert([
                'role_id' => $pair[0],
                'user_id' => $pair[1]
            ]);
        }
    }
}
