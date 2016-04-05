<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Model;
use App\Model\User;
use App\Model\Department;

class UserDepartmentTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $faker = Faker::create();

        $userIds = User::lists('id')->all();
        $departmentIds = Department::lists('id')->all();

        foreach (range(1, 100) as $index) {
            $user = User::find($faker->unique()->randomElement($userIds));
            $user->departments()->attach($faker->randomElement($departmentIds));
        }
    }
}
