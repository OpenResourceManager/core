<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/5/15
 * Time: 1:43 PM
 */

class API
{

    /**
     * @return void
     */
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
     * @param mysqli $mysqli
     * @param MySQLHelper $MySQLiHelper
     * @param string $key
     * @return array|bool
     */
    function checkAPIKey(mysqli $mysqli, MySQLHelper $MySQLiHelper, $key = '', $apiKeyTableName = '')
    {
        // Select for that api key
        $select = $MySQLiHelper->simpleSelect($mysqli, $apiKeyTableName, "key", $key);
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