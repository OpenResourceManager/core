<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Apikey;
use Illuminate\Support\Str;

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
            array('Read Write', true, true, true),
            array('Read Only', true, false, false),
            array('Write Only', false, true, true),
            array('Delete Only', false, false, true),
            array('Post Only', false, true, false),
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

                do {
                    $token = Str::quickRandom(96);
                    $exists = Apikey::where('key', $token)->first();
                } while (!empty($exists));

                Apikey::create([
                    'app_name' => $key[0] . ' ' . $model,
                    'key' => $token,
                    'can_get' . $model => $key[1],
                    'can_post' . $model => $key[2],
                    'can_delete' . $model => $key[3]
                ]);
            }
        }
    }

}