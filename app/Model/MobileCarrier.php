<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/5/15
 * Time: 12:31 PM
 */

use Illuminate\Database\Eloquent\SoftDeletes;

class MobileCarrier extends BaseModel
{
    use SoftDeletes;

    protected $table = 'mobile_carriers';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code', 'name'];

    public function phones()
    {
        return $this->belongsToMany('App\Model\Phone', 'phones');
    }

    public function code2id($code)
    {
        return $this->where('code', $code)->firstOrFail()->id;
    }

}
