<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;


class Building extends BaseApiModel
{
    use SoftDeletes;
}
