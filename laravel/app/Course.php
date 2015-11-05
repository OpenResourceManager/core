<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/5/15
 * Time: 12:31 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    protected $table = 'courses';
    protected $dates = ['deleted_at'];
}
