<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends BaseApiModel
{
    use SoftDeletes;
}
