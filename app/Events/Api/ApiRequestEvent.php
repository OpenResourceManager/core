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
     * @param User $user
     * @param string $uri
     */
    public function __construct(User $user, $uri = '')
    {
        $request = ApiRequest::create([
            'user_id' => $user->id,
            'url' => $uri
        ]);

        Log::info('API Request From: ', [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'request_id' => $request->id,
            'url' => $uri
        ]);
    }
}
