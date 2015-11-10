<?php namespace App\Model\Record;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/23/15
 * Time: 3:57 PM
 */

use App\Model\Record\Room_Record;
use App\Model\Record\Email_Record;
use App\Model\Record\Phone_Record;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Record extends Model
{
    use SoftDeletes;
    protected $table = 'user_records';
    protected $dates = ['deleted_at'];

    public function rooms()
    {
        return $this->hasMany('App\Model\Record\Room_Records');
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
