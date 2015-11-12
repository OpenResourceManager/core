<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Record\Room_Record;
use App\Model\Building;
use App\Model\Record\User_Record;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 8:39 PM
 */
class RoomRecordTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $faker = Faker::create();

        $buildingIds = Building::get()->lists('id')->all();
        $userIds = User_Record::get()->lists('id')->all();

        $floorNames = [
            'First Floor',
            'Second Floor',
            'Third Floor',
            'Fourth Floor'
        ];

        foreach (range(1, 300) as $index) {

            $user_building_pair = $faker->unique()->randomElement([[
                $faker->randomElement($userIds),
                $faker->randomElement($buildingIds),
            ]]);

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
                $roomNum = $faker->numberBetween(100, 499);
            } else {
                $roomNum = $faker->numberBetween(($floorNum * 100), (($floorNum * 100) + 99));
            }

            Room_Record::create([
                'user_id' => $user_building_pair[0],
                'building_id' => $user_building_pair[1],
                'floor_number' => $floorNum,
                'floor_name' => $floorName,
                'room_number' => $roomNum,
                'room_name' => null
            ]);
        }

    }
}