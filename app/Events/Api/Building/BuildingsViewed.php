<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Building;

use App\Events\Api\ApiRequestEvent;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class BuildingsViewed extends ApiRequestEvent
{
    /**
     * BuildingsViewed constructor.
     * @param array $buildingIds
     */
    public function __construct($buildingIds = [])
    {
        parent::__construct();

        $logMessage = 'viewed buildings - ';
        $logContext = [
            'action' => 'view',
            'model' => 'building',
            'building_ids' => $buildingIds,
            'building_id_count' => count($buildingIds),
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
                'viewed ' . count($buildingIds) . ' buildings',
                $user->id,
                'building',
                'bg-aqua'
            );

        }

        Log::info($logMessage, $logContext);
    }
}
