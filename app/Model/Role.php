<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 9:44 AM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination;

class Role extends Model
{
    use SoftDeletes;
    protected $table = 'roles';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code', 'name'];

    public function users()
    {
        return $this->hasMany('App\Model\User', 'role_user');
    }

    public function communities()
    {
        return $this->belongsToMany('App\Model\Community');
    }

}
