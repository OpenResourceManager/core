<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 3/1/16
 * Time: 3:07 PM
 */

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\BirthDate;
use App\Model\User;
use Faker\Factory as Faker;

class BirthDateTableSeeder extends Seeder
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
            BirthDate::create([
                'user_id' => $userId,
                'birth_date' => $faker->date('Y-m-d')
            ]);
        }
    }
}