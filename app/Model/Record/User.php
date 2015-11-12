<?php namespace App\Model\Record;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/23/15
 * Time: 3:57 PM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $table = 'users';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'sageid',
        'active',
        'name_prefix',
        'name_first',
        'name_middle',
        'name_last',
        'name_postfix',
        'name_phonetic',
        'username'
    ];

    public function rooms()
    {
        return $this->belongsToMany('App\Model\Record\Room', 'rooms', 'user_id', 'id');
    }

    public function emails()
    {
        return $this->hasMany('App\Model\Record\Email_Records');
    }

    public function phones()
    {
        return $this->hasMany('App\Model\Record\Phone_Records');
    }
}
