<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Apikey;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/20/15
 * Time: 3:20 PM
 */
class ApikeyTableSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();

        $keys = array(
            array('Test Key R/O', str_random(32), true, false, false, false, false, false),
            array('Test Key R/O & Password', str_random(32), true, false, false, false, true, false),
            array('Test Key Write Only', str_random(32), false, true, true, true, false, false),
            array('Test Key Write Only & Password', str_random(32), false, true, true, true, false, true),
            array('Test Key R/W', str_random(32), true, true, true, true, false, false),
            array('Test Key R/W & Password', str_random(32), true, true, true, true, true, true),
        );


        foreach ($keys as $key) {
            Apikey::create([
                'app_name' => $key[0],
                'key' => $key[1],
                'can_get' => $key[2],
                'can_post' => $key[3],
                'can_put' => $key[4],
                'can_delete' => $key[5],
                'can_view_password' => $key[6],
                'can_edit_password' => $key[7]
            ]);
        }
    }

}