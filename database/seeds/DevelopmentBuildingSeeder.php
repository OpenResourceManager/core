<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Building;

class DevelopmentBuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Building::class, 101)->create();
    }
}
