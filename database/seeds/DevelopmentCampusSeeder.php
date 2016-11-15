<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Campus;

class DevelopmentCampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Campus::class, 51)->create();
    }
}
