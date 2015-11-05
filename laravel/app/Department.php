<?php namespace App;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:32 AM
 */

use App\Program;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    protected $table = 'departments';
    protected $dates = ['deleted_at'];

    public function programs()
    {
        return $this->hasMany('App\Program');
    }
}