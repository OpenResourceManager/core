<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Http\Models\API\Duty;
use App\Http\Models\API\Account;


class AccountDutyTableSeeder extends Seeder
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
        $dutyIds = Duty::pluck('id')->all();

        foreach (range(1, 150) as $index) {
            $account = Account::find($faker->unique()->randomElement($accountIds));
            $dutyId = $faker->randomElement($dutyIds);
            // Should broadcast an attachment here for 3rd party connections
            $account->duties()->attach($dutyId);
        }
    }
}
