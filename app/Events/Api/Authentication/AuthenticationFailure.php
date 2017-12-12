<?php

namespace App\Events\Api\Authentication;

use Dingo\Api\Http\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Events\Event;
use Illuminate\Support\Facades\Log;

class AuthenticationFailure extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {

        $logMessage = \Request::ip() . ' failed to authenticated with the API - ';
        $logContext = [
            'requester_ip' => \Request::ip(),
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