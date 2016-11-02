<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends BaseApiModel
{
    use SoftDeletes;
}
