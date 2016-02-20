<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class LDAPTestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('ProductionSeeder');
        $this->call('CampusTableSeeder');
        $this->call('BuildingTableSeeder');
        $this->call('DepartmentTableSeeder');
        $this->call('CourseTableSeeder');

        Model::reguard();
    }
}
