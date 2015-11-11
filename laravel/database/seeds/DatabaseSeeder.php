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

        $this->call('UserRecordTableSeeder');
        $this->call('RoleTableSeeder');
        $this->call('CampusTableSeeder');
        $this->call('DepartmentTableSeeder');
        $this->call('BuildingTableSeeder');
        $this->call('EmailRecordTableSeeder');
        $this->call('PhoneRecordTableSeeder');
        $this->call('RoomRecordTableSeeder');
        // $this->call('CourseTableSeeder');
        $this->call('CommunityTableSeeder');
        $this->call('RoleRecordTableSeeder');
        $this->call('DepartmentRecordTableSeeder');
        $this->call('APIKeyRecordTableSeeder');

        Model::reguard();
    }
}
