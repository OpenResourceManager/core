<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Record\Phone_Record;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 8:39 PM
 */
class PhoneRecordTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $phones = array(
            array(1, '15182445765', '4765'),
            array(1, '15187032319', null),
            array(2, '15182442355', '2355'),
            array(3, '15182444582', '4582'),
        );

        foreach ($phones as $phoneArr) {
            $phone = new Phone_Record();
            $phone->user_id = $phoneArr[0];
            $phone->number = $phoneArr[1];
            $phone->ext = $phoneArr[2];
            $phone->save();
        }
    }
}