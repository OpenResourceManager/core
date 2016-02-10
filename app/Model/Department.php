<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:32 AM
 */

use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends BaseModel
{
    use SoftDeletes;

    protected $table = 'departments';
    protected $dates = ['deleted_at'];
    protected $fillable = ['academic', 'code', 'name'];

    public function courses()
    {
        return $this->hasMany('App\Model\Course');
    }

    public function courses()
    {
        return $this->hasMany('App\Model\Course');
    }

    public function code2id($code)
    {
        return $this->where('code', $code)->firstOrFail()->id;
    }
}