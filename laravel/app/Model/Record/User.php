<?php namespace App\Model\Record;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/23/15
 * Time: 3:57 PM
 */

use App\Model\Record\Room;
use App\Model\Record\Email;
use App\Model\Record\Phone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $table = 'users';
    protected $dates = ['deleted_at'];

    public function rooms()
    {
        return $this->hasMany('App\Model\Record\Room');
    }

    public function emails()
    {
        return $this->hasMany('App\Model\Record\Email');
    }

    public function phones()
    {
        return $this->hasMany('App\Model\Record\Phone');
    }
}
