<?php

namespace App\Events\Api;

use App\Models\Access\User\User;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use App\Http\Models\API\ApiRequest;


class ApiRequestEvent extends Event
{
    /**
     * ApiRequestEvent constructor.
     */
    public function __construct()
    {
        if(auth()->user()) {
            ApiRequest::create([
                'user_id' => auth()->user()->id,
                'url' => \Request::fullUrl(),
                'method' => \Request::method()
            ]);
        }
    }
}
