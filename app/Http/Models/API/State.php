<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;

class State extends BaseApiModel
{
    use SoftDeletes;
}
