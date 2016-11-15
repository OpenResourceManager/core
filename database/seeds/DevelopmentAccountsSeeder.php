<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Account;

class DevelopmentAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Account::class, 150)->create();
    }
}
