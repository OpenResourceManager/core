<?php

namespace App\Events\Api\Room;

use App\Http\Models\API\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;

class RoomCreated extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Room $room)
    {
        Log::info('Room Created:', [
            'id' => $room->id,
            'code' => $room->code,
            'label' => $room->label
        ]);

        $room->building;

        $data_to_secure = json_encode([
            'data' => $room->toArray(),
            'conf' => [
                'ldap' => ldap_config()
            ]
        ]);

        $secure_data = encrypt_broadcast_data($data_to_secure);

        $message = [
            'event' => 'created',
            'type' => 'room',
            'encrypted' => $secure_data
        ];

        Redis::publish('events', json_encode($message));

        if (auth()->user()) {
            history()->log(
                'Room',
                'created room ' . $room->room_number . ' in ' . $building->label,
                $room->id,
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
