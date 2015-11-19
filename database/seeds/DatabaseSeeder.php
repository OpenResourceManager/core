<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('UserTableSeeder');
        $this->call('EmailTableSeeder');
        $this->call('PhoneTableSeeder');
        $this->call('CampusTableSeeder');
        $this->call('BuildingTableSeeder');
        $this->call('RoomTableSeeder');
        $this->call('DepartmentTableSeeder');
        $this->call('CourseTableSeeder');
        $this->call('CommunityTableSeeder');
        $this->call('RoleTableSeeder');
        $this->call('ApiKeyTableSeeder');

        $this->call('UserCourseTableSeeder');
        $this->call('DepartmentsUsersTableSeeder');
        $this->call('UserRoleTableSeeder');

        Model::reguard();
    }
}
