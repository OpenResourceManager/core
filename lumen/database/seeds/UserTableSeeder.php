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
            array(970620, true, 'Alex', 'L', 'Markessinis', 'markea'),
            array(970621, true, 'Adam', null, 'Starnes', 'starna'),
            array(970623, true, 'John', null, 'Harris', 'harrij8')
        );


        foreach ($users as $userArr) {
            $user = new User();
            $user->sageid = $userArr[0];
            $user->active = $userArr[1];
            $user->name_first = $userArr[2];
            $user->name_middle = $userArr[3];
            $user->name_last = $userArr[4];
            $user->username = $userArr[5];
            $user->save();
        }

    }

}