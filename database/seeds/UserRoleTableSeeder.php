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
            $user = User::find($faker->unique()->randomElement($userIds));
            $user->roles()->attach($faker->randomElement($roleIds));
        }
    }
}
