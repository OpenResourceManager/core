<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an array of roles
        $roles = array(
            'DEFAULT' => 'Default',
            'STUDENT' => 'Student',
            'EMPLOYEE' => 'Employee',
            'FACULTY' => 'Faculty',
            'ADJUNCT' => 'Adjunct',
            'ALUMNI' => 'Alumni',
            'GUEST' => 'Guest',
            'TENANT' => 'Tenant'
        );

        // Loop over the array and save the data to the database
        foreach ($roles as $code => $label) {
            Role::create([
                'code' => $code,
                'label' => $label
            ]);
        }
    }
}
