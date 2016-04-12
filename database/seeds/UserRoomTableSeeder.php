<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\User;
use App\Model\Room;
use App\Model\PivotAction;
use Faker\Factory as Faker;

class UserRoomTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $faker = Faker::create();

        $userIds = User::lists('id')->all();
        $roomIds = Room::lists('id')->all();

        foreach (range(1, 150) as $index) {
            $user = User::find($faker->unique()->randomElement($userIds));
            $room_id = $faker->randomElement($roomIds);
            PivotAction::create(['id_1' => $room_id, 'id_2' => $user->id, 'class_1' => 'room', 'class_2' => 'user', 'assign' => true]);
            $user->rooms()->attach($room_id);
        }
    }
}
