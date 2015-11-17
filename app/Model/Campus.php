<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:19 AM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination;

class Campus extends Model
{
    use SoftDeletes;
    protected $table = 'campuses';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code', 'name'];

    public function buildings()
    {
        return $this->hasMany('App\Model\Building');
    }

    public function rooms()
    {
        return $this->hasManyThrough('App\Model\Room', 'App\Model\Building');

    }

    public function users()
    {
        $result = [];
        foreach ($this->rooms()->get() as $room) {
            $room = Room::find($room->id);
            foreach ($room->users->all() as $user) {
                $result[] = $user;
            }
        }

        return $result;
    }

}
