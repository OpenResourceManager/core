<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\APIKey;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/20/15
 * Time: 3:20 PM
 */
class APIKeyTableSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();

        $keys = array(
            array('Key R/O', str_random(32), true, false, false, false),
            array('Key R/W', str_random(32), true, true, true, true),
        );


        foreach ($keys as $key) {
            $model = new APIKey();
            $model->app_name = $key[0];
            $model->key = $key[1];
            $model->can_get = $key[2];
            $model->can_post = $key[3];
            $model->can_put = $key[4];
            $model->can_delete = $key[5];
            $model->save();
        }

    }

}