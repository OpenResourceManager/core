<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 3:44 PM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination;

class Room extends Model
{
    use SoftDeletes;
    protected $table = 'rooms';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'building_id',
        'floor_number',
        'floor_name',
        'room_number',
        'room_name'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Model\User', 'rooms', 'user_id', 'id');
    }
}