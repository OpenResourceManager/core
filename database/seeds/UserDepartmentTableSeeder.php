<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Model;
use App\Model\PivotAction;
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
            $department_id = $faker->randomElement($departmentIds);
            PivotAction::create(['id_1' => $department_id, 'id_2' => $user->id, 'class_1' => 'department', 'class_2' => 'user', 'assign' => true]);
            $user->departments()->attach($department_id);
        }
    }
}
