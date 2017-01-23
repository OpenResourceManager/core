<?php

namespace App\Events\Api\Room;

use App\Http\Models\API\Room;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class RoomDestroyed extends Event
{
    public function __construct(Room $room)
    {
        Log::info('Room Created:', [
            'id' => $room->id,
            'code' => $room->code,
            'label' => $room->label
        ]);

        if ($user = auth()->user()) {

            $building = $room->building;

            if (Settings::get('broadcast-events', false)) {

                $data_to_secure = json_encode([
                    'data' => $room->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'deleted',
                    'type' => 'room',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Room',
                'deleted room ' . (empty($room->label)) ? $room->code : $room->label . ' in ' . $building->label,
                $room->id,
                'building-o',
                'bg-red'
            );
        }
    }
}
