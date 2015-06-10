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
            'db_program_table' => 'program_info',
            'db_department_table' => 'department_info',
            'db_api_key_table' => 'api_keys',
        );
    }

    /**
     * @return array
     */
    public static function getProtectedAttributes()
    {
        return array('id', 'sageid', 'code');
    }

    /**
     * @return array
     */
    public static function getUserAttributes()
    {
        return array(
            'sageid' => true,
            'username' => true,
            'name_first' => true,
            'name_middle' => false,
            'name_last' => true,
            'email' => true,
            'email2' => false,
            'building' => false,
            'role' => true,
            'active' => true,
            'phone' => false,
            'room' => false
        );
    }

    /**
     * @return array
     */
    public static function getRoleAttributes()
    {
        return array(
            'code' => true,
            'name' => true
        );
    }

    /**
     * @return array
     */
    public static function getCampusAttributes()
    {
        return array(
            'code' => true,
            'name' => true
        );
    }

    /**
     * @return array
     */
    public static function getBuildingAttributes()
    {
        return array(
            'code' => true,
            'campus' => true,
            'name' => true
        );
    }

    public static function getDepartmentAttributes()
    {
        return array(
            'code' => true,
            'name' => true,
            'acedemic' => true
        );

    }

    public static function getAcademicProgramsAttributes()
    {
        return array(
            'code' => true,
            'name' => true,
            'department' => false
        );
    }

}