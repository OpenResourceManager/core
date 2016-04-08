<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 3/1/16
 * Time: 12:43 PM
 */

use Illuminate\Database\Eloquent\SoftDeletes;

class BirthDate extends BaseModel
{

    use SoftDeletes;
    protected $table = 'birth_dates';
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'birth_date'];
    protected $touches = ['user'];

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}