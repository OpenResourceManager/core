<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/13/15
 * Time: 4:32 PM
 */

return [

    'default' => 'sqlite',

    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => ':memory',
            'prefix' => '',
        ]
    ]
];