<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\User;
use App\Model\Room;
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
            DB::table('room_user')->insert([
                'room_id' => $faker->randomElement($roomIds),
                'user_id' => $faker->unique()->randomElement($userIds)
            ]);
        }
    }
}
