<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 3:44 PM
 */

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends BaseModel
{
    use SoftDeletes;

    protected $table = 'rooms';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'building_id',
        'floor_number',
        'floor_name',
        'room_number',
        'room_name'
    ];

    public function building()
    {
        return $this->belongsTo('App\Model\Building');
    }

    public function users()
    {
        return $this->belongsToMany('App\Model\User');
    }
}