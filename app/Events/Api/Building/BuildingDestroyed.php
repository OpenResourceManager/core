<?php

namespace App\Events\Api\Building;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Building;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class BuildingDestroyed extends ApiRequestEvent
{
    /**
     * BuildingDestroyed constructor.
     * @param Building $building
     */
    public function __construct(Building $building)
    {
        parent::__construct();

        $logMessage = 'destroyed building - ';
        $logContext = [
            'action' => 'destroy',
            'model' => 'building',
            'building_id' => $building->id,
            'building_code' => $building->code,
            'building_label' => $building->label,
            'building_created' => $building->created_at,
            'building_updated' => $building->updated_at,
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

                $building->campus;

                $data_to_secure = json_encode([
                    'data' => $building->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'deleted',
                    'type' => 'building',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Building',
                'destroyed a building: ' . $building->label,
                $building->id,
                'building',
                'bg-red'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
