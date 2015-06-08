<?php

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/4/15
 * Time: 12:53 PM
 */
class Config
{

    /**
     * @return array
     */
    public static function getSQLConf()
    {
        return array(
            'db_name' => 'universal_user_data',
            'db_user' => 'uudapi',
            'db_pass' => '7KH73KZWqaftwjZ6',
            'db_host' => 'localhost',
            'db_user_table' => 'user_info',
            'db_building_table' => 'building_info',
            'db_role_table' => 'role_info',
            'db_campus_table' => 'campus_info',
            'db_api_key_table' => 'api_keys',
        );
    }

    /**
     * @return array
     */
    public static function getUserAttributes()
    {
        return array(
            'id_num' => true,
            'username' => true,
            'name_first' => true,
            'name_middle' => false,
            'name_last' => true,
            'email' => true,
            'email2' => false,
            'dorm' => false,
            'role' => true,
            'active' => true,
            'phone' => false,
            'room' => false,
        );
    }

}