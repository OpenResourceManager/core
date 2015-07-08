<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Email;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 8:38 PM
 */
class EmailTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $emails = array(
            array(1, 'markea@sage.edu'),
            array(1, 'markea125@gmail.com'),
            array(1, 'markea@almyz125.com'),
            array(2, 'starna@sage.edu'),
            array(3, 'harrij8@sage.edu')
        );

        foreach ($emails as $emailArr) {
            $email = new Email();
            $email->user = $emailArr[0];
            $email->email = $emailArr[1];
            $email->save();
        }

    }

}