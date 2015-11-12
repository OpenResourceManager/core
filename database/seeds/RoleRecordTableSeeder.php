<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Record\Role_Record;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/10/15
 * Time: 2:30 PM
 */
class RoleRecordTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $role_recs = array(
            array(1, 2),
            array(1, 1),
            array(2, 2),
            array(3, 2),

        );
        foreach ($role_recs as $role_rec_arr) {
            $model = new Role_Record();
            $model->user_id = $role_rec_arr[0];
            $model->role_id = $role_rec_arr[1];
            $model->save();
        }
    }

}