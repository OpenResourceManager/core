<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 7:23 PM
 */

use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends BaseModel
{
    use SoftDeletes;
    protected $table = 'countries';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'code', 'abbreviation'];


    public function states()
    {
        return $this->hasMany('App\Model\State');
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