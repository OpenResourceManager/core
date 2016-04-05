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
            $user = User::find($faker->unique()->randomElement($userIds));
            $user->rooms()->attach($faker->randomElement($roomIds));
        }
    }
}
