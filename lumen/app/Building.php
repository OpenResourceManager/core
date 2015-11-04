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

    public function rooms()
    {
        return $this->has_many('Room');
    }

    public function delete()
    {
        $this->rooms()->delete();
        return parent::delete();
    }

    public function forceDelete()
    {
        $this->rooms()->withTrashed()->forceDelete();
        return parent::forceDelete();
    }
}
