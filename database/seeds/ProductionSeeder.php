<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
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
        $this->call('MobileCarrierTableSeeder');
        $this->call('CountryTableSeeder');
        $this->call('StateTableSeeder');

        Model::reguard();
    }
}
