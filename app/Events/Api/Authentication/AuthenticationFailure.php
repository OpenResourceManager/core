<?php

namespace App\Events\Api\Authentication;

use App\Events\Api\ApiRequestEvent;
use Dingo\Api\Http\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;

class AuthenticationFailure extends ApiRequestEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {

        parent::__construct();

        $ip = getRequestIP();

        $logMessage = $ip . ' failed to authenticated with the API - ';
        $logContext = [
            'requester_ip' => getRequestIP(),
            'request_proxy_ip' => getRequestIP(true),
            'request_method' => \Request::getMethod(),
            'request_url' => \Request::fullUrl(),
            'request_uri' => \Request::getRequestUri(),
            'request_scheme' => \Request::getScheme(),
            'request_host' => \Request::getHost(),
            'request' => $request->toArray()
        ];

        Log::warning($logMessage, $logContext);
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