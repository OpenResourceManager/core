<?php

namespace App\Events\Api\Room;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Building;
use App\Http\Models\API\Room;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class AssignedBuilding extends ApiRequestEvent
{

    /**
     * AssignedBuilding constructor.
     * @param Room $room
     * @param Building $building
     */
    public function __construct(Room $room, Building $building)
    {
        parent::__construct();

        $logMessage = 'assigned a room to building - ';
        $logContext = [
            'action' => 'assignment',
            'model' => 'room',
            'pivot' => 'building',
            'room_id' => $room->id,
            'room_code' => $room->code,
            'room_label' => $room->label,
            'room_number' => $room->number,
            'building_id' => $building->id,
            'building_code' => $building->code,
            'building_label' => $building->label,
            'room_created' => $room->created_at,
            'room_updated' => $room->updated_at,
            'requester_id' => 0,
            'requester_name' => 'System',
            'requester_ip' => getRequestIP(),
            'request_proxy_ip' => getRequestIP(true),
            'request_method' => \Request::getMethod(),
            'request_url' => \Request::fullUrl(),
            'request_uri' => \Request::getRequestUri(),
            'request_scheme' => \Request::getScheme(),
            'request_host' => \Request::getHost()
        ];

        if ($user = auth()->user()) {

            $logMessage = auth()->user()->name . ' ' . $logMessage;
            $logContext['requester_id'] = auth()->user()->id;
            $logContext['requester_name'] = auth()->user()->name;

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

        Log::info($logMessage, $logContext);
    }
}
