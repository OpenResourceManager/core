<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Community;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 11:06 AM
 */
class CommunityTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        // Create an array of communities
        $communities = array(
            array('CHESS', 'Chess Club'),
            array('STU-GOV', 'Student Government')
        );

        // Loop through the array then save the data to the database
        foreach ($communities as $commArr) {
            $comm = new Community();
            $comm->code = $commArr[0];
            $comm->name = $commArr[1];
            $comm->save();
        }
    }

}