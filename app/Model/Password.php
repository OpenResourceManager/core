<?php

namespace App\Model;

use App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Password extends BaseModel
{
    use SoftDeletes;

    protected $table = 'passwords';
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'password'];

    public function user()
    {
        return $this->belongsTo('App\Model\User');

    }
}
