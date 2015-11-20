<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\ApiKey;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/20/15
 * Time: 3:20 PM
 */
class ApiKeyTableSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();

        $keys = array(
            array('Test Key R/O', str_random(32), true, false, false, false),
            array('Test Key Write Only', str_random(32), false, true, true, true),
            array('Test Key R/W', str_random(32), true, true, true, true),
        );


        foreach ($keys as $key) {
            ApiKey::create([
                'app_name' => $key[0],
                'key' => $key[1],
                'can_get' => $key[2],
                'can_post' => $key[3],
                'can_put' => $key[4],
                'can_delete' => $key[5]
            ]);
        }
    }

}