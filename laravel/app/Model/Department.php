<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:32 AM
 */

use App\Model\Program;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    protected $table = 'departments';
    protected $dates = ['deleted_at'];

    public function programs()
    {
        return $this->hasMany('App\Model\Program');
    }

    public function courses()
    {
        $courses = array();
        foreach ($this->programs()->get() as $program) {
            foreach ($program->courses()->get() as $course) {
                $courses[] = $course;
            }
        }
        return $courses;
    }
}