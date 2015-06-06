<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/6/15
 * Time: 10:40 AM
 */
require dirname(dirname(__FILE__)) . '/vendor/autoload.php';



echo 'hello';

$app = new \Slim\Slim(array(
    'debug' => true
));
$app->get('/v1/:name', function ($name) {
    echo "Hello, " . $name;
});
$app->run();