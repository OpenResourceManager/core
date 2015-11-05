<?php namespace App;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/23/15
 * Time: 3:57 PM
 */

use App\Room;
use App\Email;
use App\Phone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $table = 'users';
    protected $dates = ['deleted_at'];

    public function rooms()
    {
        return $this->hasMany('App\Room');
    }

    public function emails()
    {
        return $this->hasMany('App\Email');
    }

    public function phones()
    {
        return $this->hasMany('App\Phone');
    }
}
