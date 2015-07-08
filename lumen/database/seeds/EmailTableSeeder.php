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
            1 => 'markea@sage.edu',
            1 => 'markea125@gmail.com',
            1 => 'markea@almyz125.com',
            2 => 'starna@sage.edu',
            3 => 'harrij8@sage.edu'
        );

        foreach ($emails as $user => $email_address) {
            $email = new Email();
            $email->user = $user;
            $email->email = $email_address;
            $email->save();
        }

    }

}