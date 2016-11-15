<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Http\Models\API\Account;
use App\Http\Models\API\Room;

class DevelopmentAccountRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $accountIds = Account::pluck('id')->all();
        $roomIds = Room::pluck('id')->all();

        foreach (range(1, 75) as $index) {
            $account = Account::find($faker->unique()->randomElement($accountIds));
            $roomId = $faker->randomElement($roomIds);
            // Should broadcast an attachment here $deptIds 3rd party connections
            $account->rooms()->attach($roomId);
        }
    }
}
