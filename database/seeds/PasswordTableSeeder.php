<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Password;
use Illuminate\Support\Facades\Crypt;
use App\Model\User;
use Faker\Factory as Faker;

class PasswordTableSeeder extends Seeder
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
            Password::create([
                'user_id' => $userId,
                'password' => Crypt::encrypt($faker->word)
            ]);
        }
    }
}
