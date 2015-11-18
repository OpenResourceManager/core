<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/5/15
 * Time: 12:31 PM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination;

class Course extends Model
{
    use SoftDeletes;
    protected $table = 'courses';
    protected $dates = ['deleted_at'];
    protected $fillable = ['department_id', 'code', 'name'];

    public function department()
    {
        return $this->belongsTo('App\Model\Department', 'courses');
    }

    public function users()
    {
        return $this->belongsToMany('App\Model\User', 'course_user');
    }

}
