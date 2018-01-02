<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Duty;

use App\Events\Api\ApiRequestEvent;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class DutiesViewed extends ApiRequestEvent
{
    /**
     * DutiesViewed constructor.
     * @param array $dutyIds
     */
    public function __construct($dutyIds = [])
    {
        parent::__construct();

        $logMessage = 'viewed duties - ';
        $logContext = [
            'action' => 'viewed',
            'model' => 'duty',
            'duty_ids' => $dutyIds,
            'duty_id_count' => count($dutyIds),
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
                'Duty',
                'viewed ' . count($dutyIds) . ' duties',
                $user->id,
                'cube',
                'bg-aqua'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
