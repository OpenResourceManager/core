<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Phone;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 8:39 PM
 */
class PhoneTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $phones = array(
            array(1, '15182445765', '4765'),
            array(1, '15182442000', '4765'),
            array(1, '15187032319', null)
        );

        foreach ($phones as $phoneArr) {
            $phone = new Phone();
            $phone->user = $phoneArr[0];
            $phone->number = $phoneArr[1];
            $phone->ext = $phoneArr[2];
            $phone->save();
        }
    }
}