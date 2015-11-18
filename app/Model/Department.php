<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:32 AM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination;

class Department extends Model
{
    use SoftDeletes;
    protected $table = 'departments';
    protected $dates = ['deleted_at'];
    protected $fillable = ['academic', 'code', 'name'];

    public function courses()
    {
        return $this->hasMany('App\Model\Course');
    }

    public function users()
    {
        return $this->hasManyThrough('App\Model\User', 'App\Model\Course');
    }
}