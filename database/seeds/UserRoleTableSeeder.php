<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\User;
use App\Model\Role;
use App\Model\PivotAction;
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
            $role_id = $faker->randomElement($roleIds);
            PivotAction::create(['id_1' => $role_id, 'id_2' => $user->id, 'class_1' => 'role', 'class_2' => 'user', 'assign' => true]);
            $user->roles()->attach($role_id);
        }
    }
}
