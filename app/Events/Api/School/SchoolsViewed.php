<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\School;

use App\Events\Api\ApiRequestEvent;
use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Log;

class SchoolsViewed extends ApiRequestEvent
{
    /**
     * SchoolsViewed constructor.
     * @param array $schoolIds
     */
    public function __construct($schoolIds = [])
    {
        parent::__construct();

        $logMessage = 'viewed schools - ';
        $logContext = [
            'action' => 'view',
            'model' => 'school',
            'school_id' => $schoolIds,
            'school_code' => count($schoolIds),
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
                'School',
                'viewed ' . count($schoolIds) . ' schools',
                $user->id,
                'university',
                'bg-aqua'
            );

        }

        Log::info($logMessage, $logContext);
    }
}
