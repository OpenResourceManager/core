<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\MobilePhone;

class DevelopmentMobilePhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MobilePhone::class, 300)->create();
    }
}
