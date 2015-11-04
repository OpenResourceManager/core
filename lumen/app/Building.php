<?php namespace App;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:30 AM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use SoftDeletes;
    protected $table = 'buildings';
    protected $dates = ['deleted_at'];

    public function delete()
    {
        Room::where('building', self::getAttribute('id'))->delete();
        return parent::delete();
    }

    public function forceDelete()
    {
        Room::where('building', self::getAttribute('id'))->withTrashed()->forceDelete();
        return parent::forceDelete();
    }
}
