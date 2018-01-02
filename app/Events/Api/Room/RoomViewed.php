<?php

namespace App\Events\Api\Room;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Room;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class RoomViewed extends ApiRequestEvent
{

    /**
     * RoomViewed constructor.
     * @param Room $room
     */
    public function __construct(Room $room)
    {

        parent::__construct();

        $logMessage = 'viewed room - ';
        $logContext = [
            'action' => 'view',
            'model' => 'room',
            'room_id' => $room->id,
            'room_code' => $room->code,
            'room_label' => $room->label,
            'room_number' => $room->number,
            'room_building_id' => $room->building->id,
            'room_building_code' => $room->building->code,
            'room_building_label' => $room->building->label,
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
                // @todo bc view event
            }

            history()->log(
                'Room',
                'viewed ' . (empty($room->label)) ? $room->code : $room->label . '.',
                $room->id,
                'building-o',
                'bg-aqua'
            );
        }

        Log::info($logMessage, $logContext);
    }
}