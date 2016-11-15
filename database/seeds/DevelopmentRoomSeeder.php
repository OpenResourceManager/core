<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Room;

class DevelopmentRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Room::class, 251)->create();
    }
}
