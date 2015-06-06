<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/5/15
 * Time: 1:43 PM
 */

include_once dirname(dirname(__FILE__)) . '/ud2sql/helpers/MySQLHelper.php';
include_once dirname(dirname(__FILE__)) . '/ud2sql/app/Config.php';

class API
{

    function unauthorized()
    {
        header('HTTP/1.1 401 Not Found');
        echo "<h1>401 Forbidden</h1>";
        Die("You are not authorized to access this page.");
    }


    /**
     * @param string $key
     * @return bool
     */
    function checkAPIKey($key = '')
    {
        echo json_encode(Config::getSQLConf());
    }

    public function updateRecord($data)
    {

    }

}