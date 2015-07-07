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

        $user = new User();

        $user->sageid = 970620;
        $user->active = true;
        $user->name_first = 'Alex';
        $user->name_middle = 'L';
        $user->name_last = 'Markessinis';
        $user->username = 'markea';

        $user->save();

    }

}