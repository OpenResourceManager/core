<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 9:38 AM
 */
class UserTableSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();

        $users = array(
            array(970620, true, 'Mr.', 'Alex', 'L', 'Markessinis', null, 'markea'),
            array(970621, true, 'Mr.', 'Adam', null, 'Starnes', null, 'starna'),
            array(970623, true, null, 'John', null, 'Harris', 'Jon', 'harrij8')
        );


        foreach ($users as $userArr) {
            $user = new User();
            $user->sageid = $userArr[0];
            $user->active = $userArr[1];
            $user->name_prefix = $userArr[2];
            $user->name_first = $userArr[3];
            $user->name_middle = $userArr[4];
            $user->name_last = $userArr[5];
            $user->name_phonetic = $userArr[6];
            $user->username = $userArr[7];
            $user->save();
        }

    }

}