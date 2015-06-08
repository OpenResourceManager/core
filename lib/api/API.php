<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/5/15
 * Time: 1:43 PM
 */

include_once dirname(dirname(__FILE__)) . '/MelonHelpers/MySQLHelper.php';
include_once 'Config.php';

class API
{

    function unauthorized()
    {
        // Set the header
        header('HTTP/1.1 401 Unauthorized');
        // some beautifuler HTML
        echo "<h1>401 Unauthorized</h1>";
        // Kill the script and send the app/user a message
        Die("You are not authorized to access this page.");
    }


    /**
     * @param string $key
     * @return array|bool
     */
    function checkAPIKey($key = '')
    {
        // Init a helper class
        $helper = new MySQLHelper();
        // Create a mysqli object
        $mysqli = $helper->getMySQLi(Config::getSQLConf());
        // Select for that api key
        $select = $helper->simpleSelect($mysqli, Config::getSQLConf()['db_api_key_table'], "key", $key);
        // Close the mysqli link
        $mysqli->close();
        // Return the api key record or false
        return ($select) ? $select->fetch_assoc() : false;
    }

    /**
     * @param array $data
     * @param array $userAttrs
     * @return bool
     */
    function checkPostDataValues($data = array(), $userAttrs = array())
    {
        foreach ($userAttrs as $key => $value) {
            if ($value == true) {
                if (!isset($data[$key]) || empty($data[$key])) {
                    return false;
                }
            }
        }
        return true;
    }
}