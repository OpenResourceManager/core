<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Email;

class DevelopmentEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Email::class, 500)->create();
    }
}
