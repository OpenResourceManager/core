<?php

namespace App\Events\Api\Authentication;

use App\Models\Access\User\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Events\Event;
use Illuminate\Support\Facades\Log;

class AuthenticationSuccess extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {

        $logMessage = $user->name . ' authenticated with the API - ';
        $logContext = [
            'requester_id' => $user->id,
            'requester_name' => $user->name,
            'requester_ip' => getRequestIP(),
            'proxy_ip' => getRequestIP(true)
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