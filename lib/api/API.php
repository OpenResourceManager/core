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
        header('HTTP/1.1 403 Not Found');
        echo "<h1>403 Forbidden</h1>";
        Die("You are not authorized to access this page.");
    }


    /**
     * @param string $key
     * @return bool
     */
    function checkAPIKey($key = '')
    {
        $mySQLHelper = new MySQLHelper();
        $mysqli = $mySQLHelper->getMySQLi(Config::getSQLConf());
        $result = $mySQLHelper->simpleSelect($mysqli, Config::getSQLConf()['db_api_key_table'], 'key', $key)->fetch_assoc();
        return ($result) ? true : false;
    }

    public function updateRecord($data)
    {

    }

}