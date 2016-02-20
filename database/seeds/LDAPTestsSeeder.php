<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

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

        $time_start = microtime(true);

        $this->call('ProductionSeeder');
        $this->call('CampusTableSeeder');
        $this->call('BuildingTableSeeder');
        $this->call('DepartmentTableSeeder');
        $this->call('CourseTableSeeder');

        Log::debug('LDAP took: ' . ((microtime(true) - $time_start) * 1000) . ' ms to seed data.');

        Model::reguard();
    }
}
