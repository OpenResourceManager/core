<?php namespace App\Model\Type;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/5/15
 * Time: 8:25 PM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Community extends Model
{
    use SoftDeletes;
    protected $table = 'communities';
    protected $dates = ['deleted_at'];

}