<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Record\Department_Record;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/10/15
 * Time: 2:47 PM
 */
class DepartmentRecordTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $models = array(
            array(1,2),
            array(2,2),
            array(3,1),
        );

        foreach ($models as $modelArr) {
            $model = new Department_Record();
            $model->user_id = $modelArr[0];
            $model->department_id = $modelArr[1];
        }
    }

}