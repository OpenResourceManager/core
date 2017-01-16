<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Campus;
use App\Http\Models\API\Course;
use App\Http\Models\API\Department;
use App\Http\Models\API\Building;
use App\Http\Models\API\Room;

class LdapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DatabaseSeeder::class);

        factory(Campus::class, 5)->create();
        factory(Building::class, 20)->create();
        factory(Room::class, 100)->create();
        factory(Department::class, 10)->create();
        factory(Course::class, 50)->create();

        /**
         * Pivots
         */
        //$this->call(DevelopmentAccountCourseSeeder::class);
        //$this->call(DevelopmentAccountDepartmentSeeder::class);
        //$this->call(DevelopmentAccountDutySeeder::class);
        //$this->call(DevelopmentAccountRoomSeeder::class);
    }
}
