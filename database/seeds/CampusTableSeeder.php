<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Type\Campus;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:36 AM
 */
class CampusTableSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();

        // Create an array of campuses
        $campuses = array(
            'TRY' => 'Russell Sage College',
            'ALB' => 'Sage College of Albany'
        );

        // Loop through the array and save the campuses
        foreach ($campuses as $code => $name) {
            $campus = new Campus();
            $campus->code = $code;
            $campus->name = $name;
            $campus->save();
        }

    }

}