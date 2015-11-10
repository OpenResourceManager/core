<?php namespace App\Model\Record;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 3:44 PM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Community_Record extends Model
{
    use SoftDeletes;
    protected $table = 'community_records';
    protected $dates = ['deleted_at'];
}