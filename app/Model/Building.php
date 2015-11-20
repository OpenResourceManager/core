<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:30 AM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination;

class Building extends Model
{
    use SoftDeletes;
    protected $table = 'buildings';
    protected $dates = ['deleted_at'];
    protected $fillable = ['campus_id', 'code', 'name'];

    public function rooms()
    {
        return $this->hasMany('App\Model\Room');
    }

    public function users()
    {

        return $this->rooms()->with('users');

        /*$users = [];
        foreach ($this->rooms as $room) {
            $users[] = User::find($room->user_id);
        }
        return $users; */
    }

    public function campus()
    {
        return $this->belongsTo('App\Model\Campus');
    }

    public function communities()
    {
        return $this->belongsToMany('App\Model\Community');
    }
}

