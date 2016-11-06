<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Address;

class DevelopmentAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Address::class, 250)->create();
    }
}
