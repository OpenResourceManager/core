<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/5/15
 * Time: 12:46 PM
 */


$api = new API();

if ($_POST['X-Authorization']) {
    if ($api->checkAPIKey($_POST['X-Authorization'])) {

    } else {
        $api->unauthorized();
    }
} else {
    $api->unauthorized();
}
