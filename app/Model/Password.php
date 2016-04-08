<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/15/16
 * Time: 6:00 PM
 */

use Illuminate\Database\Eloquent\SoftDeletes;

class Password extends BaseModel
{
    use SoftDeletes;

    protected $table = 'passwords';
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'password'];
    protected $touches = ['user'];

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}
