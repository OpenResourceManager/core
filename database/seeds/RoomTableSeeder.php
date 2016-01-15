<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Room;
use App\Model\Building;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 8:39 PM
 */
class RoomTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $faker = Faker::create();

        $buildingIds = Building::get()->lists('id')->all();

        $floorNames = [
            'First Floor',
            'Second Floor',
            'Third Floor',
            'Fourth Floor'
        ];

        foreach (range(1, 200) as $index) {

            $floorNum = $faker->optional()->numberBetween(1, 4);
            $floorName = null;
            if ($floorNum == 1) {
                $floorName = $floorNames[0];
            } elseif ($floorNum == 2) {
                $floorName = $floorNames[1];
            } elseif ($floorNum == 3) {
                $floorName = $floorNames[2];
            } elseif ($floorNum == 4) {
                $floorName = $floorNames[3];
            }

            if (is_null($floorNum)) {
                $roomNum = $faker->numberBetween(100, 999);
            } else {
                $roomNum = $faker->numberBetween(($floorNum * 100), (($floorNum * 100) + 99));
            }


            $codearr = [
                $faker->word,
                $faker->word . $faker->numberBetween(($floorNum * 100), (($floorNum * 100) + 99)),
                $faker->numberBetween(($floorNum * 100), (($floorNum * 100) + 99))
            ];

            Room::create([
                'code' => $faker->unique()->randomElement($codearr),
                'building_id' => $faker->randomElement($buildingIds),
                'floor_number' => $floorNum,
                'floor_name' => $floorName,
                'room_number' => $roomNum,
                'room_name' => $faker->optional()->words
            ]);
        }

    }
}
