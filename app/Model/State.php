<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 7:23 PM
 */

use Illuminate\Database\Eloquent\SoftDeletes;

class State extends BaseModel
{
    use SoftDeletes;
    protected $table = 'states';
    protected $dates = ['deleted_at'];
    protected $fillable = ['country_id', 'name', 'code'];

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }

    public function addresses()
    {
        return $this->hasMany('App\Model\Address');
    }

    public function users()
    {
        return $this->hasManyThrough('App\Model\User', 'App\Model\Address');
    }

}