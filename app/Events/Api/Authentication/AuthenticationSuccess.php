<?php

namespace App\Events\Api\Authentication;

use App\Events\Api\ApiRequestEvent;
use App\Models\Access\User\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;

class AuthenticationSuccess extends ApiRequestEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {

        parent::__construct();

        $logMessage = $user->name . ' authenticated with the API - ';
        $logContext = [
            'requester_id' => $user->id,
            'requester_name' => $user->name,
            'requester_ip' => getRequestIP(),
            'request_proxy_ip' => getRequestIP(true),
            'request_method' => \Request::getMethod(),
            'request_url' => \Request::fullUrl(),
            'request_uri' => \Request::getUri(),
            'request_scheme' => \Request::getScheme(),
            'request_host' => \Request::getHost()
        ];

        Log::info($logMessage, $logContext);

        auth()->login($user);
        history()->log(
            'Authentication',
            'authenticated with the API',
            $user->id,
            'key',
            'bg-green'
        );
        auth()->logout();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     *
     * public function broadcastOn()
     * {
     * return new PrivateChannel('channel-name');
     * }
     */
}