<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Record\User_Record;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 9:38 AM
 */
class UserRecordTableSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();

        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            User_Record::create([
                'sageid' => $faker->unique()->randomNumber($nbDigits = 7, $strict = true),
                'active' => $faker->boolean(),
                'name_prefix' => $faker->optional()->title,
                'name_first' => $faker->firstName,
                'name_middle' => $faker->optional()->firstName,
                'name_last' => $faker->lastName,
                'name_postfix' => $faker->optional()->title,
                'name_phonetic' => $faker->optional()->firstName,
                'username' => $faker->unique()->userName
            ]);
        }


        /* $users = array(
              array(970620, true, 'Mr.', 'Alex', 'L', 'Markessinis', null, 'markea'),
              array(970621, true, 'Mr.', 'Adam', null, 'Starnes', null, 'starna'),
              array(970623, true, null, 'John', null, 'Harris', 'Jon', 'harrij8')
          );


          foreach ($users as $userArr) {
              $user = new User_Record();
              $user->sageid = $userArr[0];
              $user->active = $userArr[1];
              $user->name_prefix = $userArr[2];
              $user->name_first = $userArr[3];
              $user->name_middle = $userArr[4];
              $user->name_last = $userArr[5];
              $user->name_phonetic = $userArr[6];
              $user->username = $userArr[7];
              $user->save();
          } */

    }

}