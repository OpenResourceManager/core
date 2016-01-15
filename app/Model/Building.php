<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:30 AM
 */

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends BaseModel
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

        return $this->manyThroughMany('App\Model\User', 'App\Model\Room', 'building_id', 'id', 'user_id');

        /**
         * Will Work... but has no way to paginate
         *
         * $users = array();
         * foreach ($this->rooms()->get() as $room) {
         * foreach ($room->users()->get() as $user) {
         * unset($user->pivot);
         * $users[] = $user;
         * }
         * }
         * return Collection::make($users);
         */
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

