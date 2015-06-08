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
            'db_name' => 'ud2sql',
            'db_user' => 'ud2sql',
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
    public static function getLDAPConf()
    {
        return array(
            'ldap_user' => 'ud2sql',
            'ldap_bind_dn' => 'CN=ud2sql,OU=Users_TSC,DC=SAGE,DC=EDU',
            'ldap_pass' => 'tU9ZyhjDb77HBHVu',
            'ldap_hosts' => array(
                '5.254.254.222',
                '5.17.254.222',
                '5.254.254.223'
            ),
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