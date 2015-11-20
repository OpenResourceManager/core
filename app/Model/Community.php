<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/5/15
 * Time: 8:25 PM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination;

class Community extends Model
{
    use SoftDeletes;
    protected $table = 'communities';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'code',
        'name'
    ];

    public function users()
    {
        return $this->hasMany('App\Model\User');
    }

    public function courses()
    {
        return $this->hasMany('App\Model\Course');
    }

    public function departments()
    {
        return $this->hasMany('App\Model\Department');
    }

    public function roles()
    {
        return $this->hasMany('App\Model\Role');
    }

    public function buildings()
    {
        return $this->hasMany('App\Model\Building');
    }

    public function campuses()
    {
        return $this->hasMany('App\Model\Campus');
    }

}