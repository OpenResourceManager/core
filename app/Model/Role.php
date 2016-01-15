<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 9:44 AM
 */

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends BaseModel
{
    use SoftDeletes;

    protected $table = 'roles';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code', 'name'];

    public function users()
    {
        return $this->hasMany('App\Model\User');
    }
}
