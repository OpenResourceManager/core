<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/23/15
 * Time: 3:57 PM
 */

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends BaseModel
{
    use SoftDeletes;

    protected $table = 'users';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_identifier',
        'name_prefix',
        'name_first',
        'name_middle',
        'name_last',
        'name_postfix',
        'name_phonetic',
        'username'
    ];

    public function password()
    {
        return $this->hasOne('App\Model\Password');
    }

    public function emails()
    {
        return $this->hasMany('App\Model\Email');
    }

    public function phones()
    {
        return $this->hasMany('App\Model\Phone');
    }

    public function rooms()
    {
        return $this->belongsToMany('App\Model\Room', 'room_user');
    }

    public function buildings()
    {
        return $this->hasManyThrough('App\Model\Building', 'App\Model\Room');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Model\Role');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Model\Course');
    }
}
