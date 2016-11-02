<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends BaseApiModel
{
    use SoftDeletes;
}
