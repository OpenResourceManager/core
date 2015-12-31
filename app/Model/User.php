<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/23/15
 * Time: 3:57 PM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination;

class User extends Model
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
        return $this->belongsToMany('App\Model\Room', 'rooms', 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Model\Role');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Model\Course');
    }

    public function communities()
    {
        return $this->belongsToMany('App\Model\Community');
    }
}
