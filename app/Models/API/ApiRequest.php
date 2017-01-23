<?php

namespace App\Http\Models\API;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiRequest extends BaseApiModel
{
    use SoftDeletes;
    protected $table = 'api_requests';
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'url', 'method'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
