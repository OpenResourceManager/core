<?php

namespace App\Events\Api\Room;

use App\Http\Models\API\Building;
use App\Http\Models\API\Room;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class AssignedBuilding extends Event
{

    /**
     * AssignedBuilding constructor.
     * @param Room $room
     * @param Building $building
     */
    public function __construct(Room $room, Building $building)
    {
        $info = [
            'room_id' => $room->id,
            'room_code' => $room->code,
            'room_number' => $room->room_number,
            'building_id' => $building->id,
            'building_code' => $building->code,
            'building_label' => $building->label
        ];

        Log::info('Room assigned to Building:', $info);

        if ($user = auth()->user()) {

            if (Settings::get('broadcast-events', false)) {

                $data_to_secure = json_encode([
                    'data' => [
                        'room' => $room->toArray(),
                        'building' => $building->toArray()
                    ],
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'assigned',
                    'type' => 'building',
                    'to' => 'room',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Assignment',
                'assigned ' . (empty($room->label)) ? $room->code : $room->label . ' to building: "' . $building->label . '"',
                $room->id,
                'building-o',
                'bg-olive'
            );
        }
    }
}
