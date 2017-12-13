<?php

namespace App\Events\Api\Room;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Building;
use App\Http\Models\API\Room;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class UnassignedBuilding extends ApiRequestEvent
{

    /**
     * UnassignedBuilding constructor.
     * @param Room $room
     * @param Building $building
     */
    public function __construct(Room $room, Building $building)
    {
        parent::__construct();

        $info = [
            'room_id' => $room->id,
            'room_code' => $room->code,
            'room_number' => $room->room_number,
            'building_id' => $building->id,
            'building_code' => $building->code,
            'building_label' => $building->label
        ];

        Log::info('Room unassigned from Building:', $info);

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
                    'event' => 'unassigned',
                    'type' => 'building',
                    'to' => 'room',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Assignment',
                'removed room: ' . (empty($room->label)) ? $room->code : $room->label . ' from building: "' . $building->label . '"',
                $room->id,
                'building-o',
                'bg-yellow'
            );
        }
    }
}
