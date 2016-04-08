<?php namespace App\Model;


use Illuminate\Database\Eloquent\SoftDeletes;

class PivotAction extends BaseModel
{
    use SoftDeletes;

    protected $table = 'pivot_actions';
    protected $fillable = ['id_1', 'id_2', 'class_1', 'class_2', 'action'];
    protected $dates = ['deleted_at'];
}
