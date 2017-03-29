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

        $this->call(DatabaseSeeder::class);
        $this->call(DevelopmentAccountsSeeder::class);
        $this->call(DevelopmentAliasAccountsSeeder::class);
        $this->call(DevelopmentEmailSeeder::class);
        $this->call(DevelopmentMobilePhoneSeeder::class);
        $this->call(DevelopmentAddressSeeder::class);
        $this->call(DevelopmentCampusSeeder::class);
        $this->call(DevelopmentBuildingSeeder::class);
        $this->call(DevelopmentRoomSeeder::class);
        $this->call(DevelopmentDepartmentSeeder::class);
        $this->call(DevelopmentCourseSeeder::class);
        /**
         * Pivots
         */
        $this->call(DevelopmentAccountCourseSeeder::class);
        $this->call(DevelopmentAccountDepartmentSeeder::class);
        $this->call(DevelopmentAccountDutySeeder::class);
        $this->call(DevelopmentAccountRoomSeeder::class);
    }
}
