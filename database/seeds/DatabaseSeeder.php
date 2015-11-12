<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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

        $this->call('RoleTableSeeder');
        $this->call('CampusTableSeeder');
        $this->call('BuildingTableSeeder');
        $this->call('DepartmentTableSeeder');
        $this->call('CourseTableSeeder');
        $this->call('CommunityTableSeeder');

        $this->call('UserRecordTableSeeder');
        $this->call('EmailRecordTableSeeder');
        $this->call('PhoneRecordTableSeeder');
        $this->call('RoomRecordTableSeeder');
        $this->call('RoleRecordTableSeeder');
        $this->call('DepartmentRecordTableSeeder');
        $this->call('APIKeyRecordTableSeeder');

        Model::reguard();
    }
}
