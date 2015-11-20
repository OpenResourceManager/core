<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Role;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 9:44 AM
 */
class RoleTableSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();

        // Create an array of roles
        $roles = array(
            'STUDENT' => 'Student',
            'EMPLOYEE' => 'Employee',
            'FACULTY' => 'Faculty',
            'ADJUNCT' => 'Adjunct'
        );

        // Loop over the array and save the data to the database
        foreach ($roles as $code => $name) {
            Role::create([
                'code' => $code,
                'name' => $name
            ]);
        }
    }

}