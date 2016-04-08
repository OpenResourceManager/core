<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 3:29 PM
 */

use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends BaseModel
{
    use SoftDeletes;

    protected $table = 'emails';
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'email'];
    protected $touches = ['user'];

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}