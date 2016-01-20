<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Apikey;

/**
 * Created by PhpStorm.
 * : melon
 * Date: 10/20/15
 * Time: 3:20 PM
 */
class ApikeyTableSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();

        $keys = array(
            array('R/W', str_random(32), true, true, true),
        );

        $models = [
            '',
            '_address',
            '_building',
            '_campus',
            '_country',
            '_course',
            '_department',
            '_email',
            '_password',
            '_phone',
            '_role',
            '_room',
            '_state',
            '_user',
        ];


        foreach ($keys as $key) {
            foreach ($models as $model) {
                Apikey::create([
                    'app_name' . $model => $key[0] . ' ' . $model,
                    'key' => $key[1],
                    'can_get' . $model => $key[2],
                    'can_post' . $model => $key[3],
                    'can_delete' . $model => $key[4]
                ]);
            }
        }
    }

}