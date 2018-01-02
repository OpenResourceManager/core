<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Room;

use App\Events\Api\ApiRequestEvent;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class RoomsViewed extends ApiRequestEvent
{
    /**
     * RoomViewed constructor.
     * @param array $roomIds
     */
    public function __construct($roomIds = [])
    {
        parent::__construct();

        $logMessage = 'viewed rooms - ';
        $logContext = [
            'action' => 'view',
            'model' => 'room',
            'room_ids' => $roomIds,
            'room_id_count' => count($roomIds),
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
                'viewed ' . count($roomIds) . ' rooms',
                $user->id,
                'building-o',
                'bg-aqua'
            );

        }

        Log::info($logMessage, $logContext);
    }
}
