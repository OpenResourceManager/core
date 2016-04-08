<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 6:00 PM
 */

use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends BaseModel
{
    use SoftDeletes;
    protected $table = 'addresses';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'addressee',
        'organization',
        'line_1',
        'line_2',
        'city',
        'state_id',
        'zip',
        'country_id',
        'latitude',
        'longitude'
    ];
    protected $touches = ['user'];

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }

    public function state()
    {
        return $this->belongsTo('App\Model\State');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

}
