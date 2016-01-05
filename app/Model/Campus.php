<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:19 AM
 */

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campus extends BaseModel
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
        $rooms = $this->rooms()->with('users')->with('paginate')->get();
        $result = collect([]);
        foreach ($rooms as $room) {
            $result = $result->merge($room->users);
        }
        return $result;
    }

    public function communities()
    {
        return $this->belongsToMany('App\Model\Community');
    }
}
