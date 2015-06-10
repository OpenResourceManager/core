<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/9/15
 * Time: 2:00 PM
 */
class Controller
{

    /**
     * @param array $apiKey
     * @param array $info
     * @return array
     */
    public function getRoot(array $apiKey, array $info)
    {
        return array(
            'application' => $apiKey['app'],
            'success' => true,
            'result' => $info
        );
    }

    /**
     * @param array $apiKey
     * @param MySQLHelper $MySQLiHelper
     * @param array $sqlConfig
     * @param string $table
     * @param string $by
     * @param $value
     * @return array
     */
    public function getBy(array $apiKey, MySQLHelper $MySQLiHelper, array $sqlConfig, $table = '', $by = '', $byValue)
    {
        $mysqli = $MySQLiHelper->getMySQLi($sqlConfig['db_user'], $sqlConfig['db_pass'], $sqlConfig['db_name'], $sqlConfig['db_host']);
        if ($result = $MySQLiHelper->simpleSelect($mysqli, $table, $by, $byValue)->fetch_assoc()) {
            $mysqli->close();
            return array('application' => $apiKey['app'], 'success' => true, 'result' => $result);
        } else {
            $mysqli->close();
            header('HTTP/1.1 404 Not Found');
            return array('application' => $apiKey['app'], 'success' => false, 'error' => 'NotFound');
        }
    }

    /**
     * @param array $apiKey
     * @param MySQLHelper $MySQLiHelper
     * @param array $sqlConfig
     * @param string $table
     * @param int $limit
     * @return array
     */
    public function getMultiple(array $apiKey, MySQLHelper $MySQLiHelper, array $sqlConfig, $table = '', $limit = 0)
    {
        $mysqli = $MySQLiHelper->getMySQLi($sqlConfig['db_user'], $sqlConfig['db_pass'], $sqlConfig['db_name'], $sqlConfig['db_host']);
        if ($result = $MySQLiHelper->selectAllFrom($mysqli, $table, $limit)->fetch_all(MYSQLI_ASSOC)) {
            $mysqli->close();
            return array('application' => $apiKey['app'], 'success' => true, 'result' => $result);
        } else {
            $mysqli->close();
            header('HTTP/1.1 404 Not Found');
            return array('application' => $apiKey['app'], 'success' => false, 'error' => 'NotFound');
        }
    }

    /**
     * @param Controller $Controller
     * @param array $apiKey
     * @param MySQLHelper $MySQLiHelper
     * @param array $sqlConfig
     * @param string $table
     * @param string $by
     * @param $byValue
     * @param array $data
     * @param array $objectAttributes
     * @return array
     */
    public function postToBy(Controller $Controller, array $apiKey, MySQLHelper $MySQLiHelper, array $sqlConfig, $table = '', $by = '', $byValue, array $data, array $objectAttributes)
    {
        if ($apiKey['write'] == 1) {
            if (!empty($data)) {
                $mysqli = $MySQLiHelper->getMySQLi($sqlConfig['db_user'], $sqlConfig['db_pass'], $sqlConfig['db_name'], $sqlConfig['db_host']);
                $exists = ($MySQLiHelper->simpleSelect($mysqli, $table, $by, $byValue)->fetch_assoc()) ? true : false;
                if ($exists) {
                    foreach (Config::getProtectedAttributes() as $attr) {
                        if (isset($data[$attr])) unset($data[$attr]);
                    }
                    if ($MySQLiHelper->simpleUpdate($mysqli, $table, $data, $by, $byValue)) {
                        $mysqli->close();
                        return array('application' => $apiKey['app'], 'success' => true, 'result' => 'update');
                    } else {
                        $mysqli->close();
                        header('HTTP/1.1 500 Server Error');
                        return array('application' => $apiKey['app'], 'success' => false, 'error' => 'FailedToWrite');
                    }
                } else {
                    if ($Controller->checkPostDataValues($data, $objectAttributes)) {
                        if ($MySQLiHelper->simpleInsert($mysqli, $table, $data)) {
                            $mysqli->close();
                            return array('application' => $apiKey['app'], 'success' => true, 'result' => 'create');
                        } else {
                            $mysqli->close();
                            header('HTTP/1.1 500 Server Error');
                            return array('application' => $apiKey['app'], 'success' => false, 'error' => 'FailedToWrite');
                        }
                    } else {
                        $mysqli->close();
                        header('HTTP/1.1 400 Bad Request');
                        return array('application' => $apiKey['app'], 'success' => false, 'error' => 'InsufficientPostData', 'required' => $objectAttributes);
                    }
                }
            } else {
                header('HTTP/1.1 400 Bad Request');
                return array('application' => $apiKey['app'], 'success' => false, 'error' => 'InsufficientPostData', 'required' => $objectAttributes);
            }
        } else {
            header('HTTP/1.1 403 Forbidden');
            return array('application' => $apiKey['app'], 'success' => false, 'error' => 'ForbiddenToWrite');
        }
    }

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