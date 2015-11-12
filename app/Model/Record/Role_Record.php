<?php namespace App\Model\Record;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 3:44 PM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role_Record extends Model
{
    use SoftDeletes;
    protected $table = 'role_records';
    protected $dates = ['deleted_at'];
}