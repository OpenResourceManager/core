<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Chrisbjr\ApiGuard\Models\ApiKey;

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

        foreach (range(1, 4) as $index) {
            $apiKey = new ApiKey();
            $apiKey->key = $apiKey->generateKey();
            $apiKey->save();
        }

    }

}