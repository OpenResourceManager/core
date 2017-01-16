<?php

namespace App\Events\Api\Duty;

use App\Http\Models\API\Duty;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;

class DutyCreated extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Duty $duty)
    {

        Log::info('Duty Created:', [
            'id' => $duty->id,
            'code' => $duty->code,
            'label' => $duty->label
        ]);

        $data_to_secure = json_encode([
            'data' => $duty->toArray(),
            'conf' => [
                'ldap' => ldap_config()
            ]
        ]);

        $secure_data = encrypt_broadcast_data($data_to_secure);

        $message = [
            'event' => 'created',
            'type' => 'duty',
            'encrypted' => $secure_data
        ];

        Redis::publish('events', json_encode($message));

        if (auth()->user()) {
            history()->log(
                'Duty',
                'created a new duty: ' . $duty,
                $duty->id,
                'university',
                'bg-green'
            );
        }

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    #public function broadcastOn()
    #{
    #    return new PrivateChannel('channel-name');
    #}
}
