<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Http\Models\API\Role;
use App\Http\Models\API\Account;


class AccountRoleTableSeeder extends Seeder
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
        $roleIds = Role::pluck('id')->all();

        foreach (range(1, 150) as $index) {
            $account = Account::find($faker->unique()->randomElement($accountIds));
            $roleId = $faker->randomElement($roleIds);
            // Should broadcast an attachment here for 3rd party connections
            $account->roles()->attach($roleId);
        }
    }
}
