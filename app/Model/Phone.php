<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 3:29 PM
 */

use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends BaseModel
{
    use SoftDeletes;

    protected $table = 'phones';
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'number', 'ext', 'is_cell', 'carrier'];

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function carrier()
    {
        return $this->belongsTo('App\Model\MobileCarrier', 'mobile_carrier_id');
    }

}