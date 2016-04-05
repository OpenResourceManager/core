<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 4/5/16
 * Time: 4:26 PM
 */

use Illuminate\Database\Eloquent\SoftDeletes;

class SocialSecurityNumber extends BaseModel
{
    use SoftDeletes;

    protected $table = 'social_security_numbers';
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'social_security_number'];

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
    
}
