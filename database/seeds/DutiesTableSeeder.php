<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Duty;

class DutiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an array of duties
        $duties = array(
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
        foreach ($duties as $code => $label) {
            Duty::create([
                'code' => $code,
                'label' => $label
            ]);
        }
    }
}
