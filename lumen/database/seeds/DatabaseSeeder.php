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

        $this->call('UserTableSeeder');
        $this->call('RoleTableSeeder');
        $this->call('CampusTableSeeder');
        $this->call('DepartmentTableSeeder');
        $this->call('BuildingTableSeeder');
        $this->call('ProgramTableSeeder');
        $this->call('EmailTableSeeder');
        $this->call('PhoneTableSeeder');
        $this->call('RoomTableSeeder');
        $this->call('APIKeyTableSeeder');
    }

}
