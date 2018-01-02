<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\LoadStatus;

use App\Events\Api\ApiRequestEvent;
use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Log;

class LoadStatusesViewed extends ApiRequestEvent
{
    /**
     * LoadStatusesViewed constructor.
     * @param array $schoolIds
     */
    public function __construct($schoolIds = [])
    {
        parent::__construct();

        $logMessage = 'viewed load statuses - ';
        $logContext = [
            'action' => 'view',
            'model' => 'load_status',
            'load_status_ids' => $schoolIds,
            'load_status_id_count' => count($schoolIds),
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
                'LoadStatus',
                'viewed ' . count($schoolIds) . ' load statuses',
                $user->id,
                'cubes',
                'bg-aqua'
            );

        }

        Log::info($logMessage, $logContext);
    }
}
