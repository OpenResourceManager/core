<?php

namespace App\Events\Api\Room;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Room;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class RoomRestored extends ApiRequestEvent
{

    public function __construct(Room $room)
    {
        parent::__construct();

        Log::info('Room Restored:', [
            'id' => $room->id,
            'code' => $room->code,
            'label' => $room->label
        ]);

        if ($user = auth()->user()) {

            if (Settings::get('broadcast-events', false)) {

                $room->campus;

                $data_to_secure = json_encode([
                    'data' => $room->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'restored',
                    'type' => 'room',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Room',
                'restored a room: ' . (empty($room->label)) ? $room->code : $room->label . '.',
                $room->id,
                'building-o',
                'bg-lime'
            );
        }
    }
}
