<?php

namespace App\Events\Api\Building;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Building;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class BuildingViewed extends ApiRequestEvent
{
    /**
     * BuildingViewed constructor.
     * @param Building $building
     */
    public function __construct(Building $building)
    {

        parent::__construct();

        $logMessage = 'viewed building - ';
        $logContext = [
            'action' => 'view',
            'model' => 'building',
            'building_id' => $building->id,
            'building_identifier' => $building->code,
            'building_username' => $building->label,
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
                // @todo bc view event
            }

            history()->log(
                'Building',
                'viewed ' . $building->label . '.',
                $building->id,
                'building',
                'bg-aqua'
            );
        }

        Log::info($logMessage, $logContext);
    }
}