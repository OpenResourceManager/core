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
    const UPDATED_AT = 'campuses.updated_at';
    protected $table = 'campuses';
    protected $dates = ['deleted_at'];

    public function buildings()
    {
        return $this->hasMany('App\Building');
    }

    public function rooms()
    {
        return $this->hasManyThrough('App\Room', 'App\Building');
    }

}
