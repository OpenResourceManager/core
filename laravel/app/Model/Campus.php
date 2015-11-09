<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:19 AM
 */

use App\Model\Building;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campus extends Model
{
    use SoftDeletes;
    protected $table = 'campuses';
    protected $dates = ['deleted_at'];

    public function buildings()
    {
        return $this->hasMany('App\Model\Building');
    }

    public function rooms()
    {
        $rooms = array();
        foreach ($this->buildings()->get() as $building) {
            foreach ($building->rooms()->get() as $room) {
                $rooms[] = $room;
            }
        }
        return $rooms;
    }

}