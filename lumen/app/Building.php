<?php namespace App;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:30 AM
 */

use App\Room;
use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use SoftDeletes;
    protected $table = 'buildings';
    protected $dates = ['deleted_at'];

    public function rooms()
    {
        return $this->hasMany('Room');
    }

    public static function boot()
    {
        parent::boot();

        Log:notice('This is a log.');

        static::deleted(function ($building) {
            Log:notice('the delete event has fucking fired');
            $building->rooms()->delete();
        });
    }
}

