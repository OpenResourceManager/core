<?php

use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SystemEntitiesSeeder::class);
        $this->call(DevelopmentUserSeeder::class);
        $this->call(AccountsTableSeeder::class);
        $this->call(EmailTableSeeder::class);
        /**
         * Pivots
         */
        $this->call(AccountDutyTableSeeder::class);
    }
}
