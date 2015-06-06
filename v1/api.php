<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/6/15
 * Time: 10:40 AM
 */
require dirname(dirname(__FILE__)) . 'vendor/autoload.php';

$app = new \Slim\Slim();
$app->get('/hello/:name', function ($name) {
    echo "Hello, " . $name;
});
$app->run();