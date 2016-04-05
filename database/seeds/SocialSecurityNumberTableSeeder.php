<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\SocialSecurityNumber;
use Illuminate\Support\Facades\Crypt;
use App\Model\User;
use Faker\Factory as Faker;

class SocialSecurityNumberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $faker = Faker::create();
        $userIds = User::get()->lists('id')->all();

        foreach ($userIds as $userId) {
            SocialSecurityNumber::create([
                'user_id' => $userId,
                'social_security_number' => Crypt::encrypt($faker->randomNumber(4, true))
            ]);
        }
    }
}
