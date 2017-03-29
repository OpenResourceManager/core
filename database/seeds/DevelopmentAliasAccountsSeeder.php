<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\AliasAccount;

class DevelopmentAliasAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(AliasAccount::class, 105)->create();
    }
}
