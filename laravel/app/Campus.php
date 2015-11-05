<?php namespace App;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:19 AM
 */

use App\Building;
use App\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campus extends Model
{
    use SoftDeletes;
    protected $table = 'campuses';
    protected $dates = ['deleted_at'];

    public function buildings()
    {
        return $this->hasMany('App\Building');
    }

    public function rooms()
    {
        $rooms = array();
        $buildings = $this->buildings()->get();
        foreach($buildings as $building) {
            echo json_encode($building->rooms()->get());
        }
        return '';
    }

}
