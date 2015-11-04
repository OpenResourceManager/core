<?php namespace App;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:19 AM
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campus extends Model
{
    use SoftDeletes;
    protected $table = 'campuses';
    protected $dates = ['deleted_at'];

    public function delete()
    {
        Building::where('campus', $this->id)->delete();
        return parent::delete();
    }

    public function forceDelete()
    {
        Building::where('campus', $this->id)->withTrashed()->forceDelete();
        return parent::forceDelete();
    }
}
