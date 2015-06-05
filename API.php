<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/5/15
 * Time: 12:46 PM
 */

if ($data_sent = ($_GET['update'] | $_POST['update'])) {

    echo json_encode($data_sent);

} else {

}