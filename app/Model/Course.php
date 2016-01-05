<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/5/15
 * Time: 12:31 PM
 */

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends BaseModel
{
    use SoftDeletes;

    protected $table = 'courses';
    protected $dates = ['deleted_at'];
    protected $fillable = ['department_id', 'code', 'name'];

    public function users()
    {
        return $this->belongsToMany('App\Model\User');
    }

    public function department()
    {
        return $this->belongsTo('App\Model\Department');
    }

    public function communities()
    {
        return $this->belongsToMany('App\Model\Community');
    }

}
