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
        // Set the header
        header('HTTP/1.1 401 Forbidden');
        // some beautifuler HTML
        echo "<h1>401 Forbidden</h1>";
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
     * @param string $idnum
     * @param array $data
     * @param mysqli $mysqli
     * @param MySQLHelper $helper
     * @return array
     */
    public function updateRecordSageID($idnum = '', $data = array(), mysqli $mysqli, MySQLHelper $helper)
    {
        if ($record = $helper->simpleSelect($mysqli, Config::getSQLConf()['db_user_table'], 'id_num', $idnum)) {
            return array('result' => 'update', 'success' => $helper->simpleUpdate($mysqli, Config::getSQLConf()['db_users_table'], $data, 'id_num', $idnum));
        } else {
            return array('result' => 'create', 'success' => $helper->simpleInsert($mysqli, Config::getSQLConf()['db_users_table'], $data));
        }
    }
}