<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Room;

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

        $rooms = array(
            array(1, 17, 0, 'Basement', 1, 'Network Office')
        );

        foreach ($rooms as $roomArr) {
            $room = new Room();
            $room->user = $roomArr[0];
            $room->building = $roomArr[1];
            $room->floor = $roomArr[2];
            $room->floor_name = $roomArr[3];
            $room->room = $roomArr[4];
            $room->room_name = $roomArr[5];
            $room->save();
        }
    }
}