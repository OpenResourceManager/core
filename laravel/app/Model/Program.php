<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:34 AM
 */

use App\Model\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;
    protected $table = 'programs';
    protected $dates = ['deleted_at'];

    public function courses()
    {
        return $this->hasMany('App\Model\Course');
    }
}