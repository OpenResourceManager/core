<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/6/15
 * Time: 10:40 AM
 */
require dirname(dirname(__FILE__)) . 'vendor/autoload.php';

$app = new \Slim\Slim(array(
    'debug' => true
));
$app->get('/api/v1/:name', function ($name) {
    echo "Hello, " . $name;
});
$app->run();