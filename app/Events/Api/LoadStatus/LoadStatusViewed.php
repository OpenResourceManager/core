<?php

namespace App\Events\Api\LoadStatus;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\LoadStatus;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class LoadStatusViewed extends ApiRequestEvent
{
    /**
     * LoadStatusViewed constructor.
     * @param LoadStatus $loadStatus
     */
    public function __construct(LoadStatus $loadStatus)
    {

        parent::__construct();

        $logMessage = 'viewed load status - ';
        $logContext = [
            'action' => 'view',
            'model' => 'load_status',
            'load_status_id' => $loadStatus->id,
            'load_status_code' => $loadStatus->code,
            'load_status_label' => $loadStatus->label,
            'load_status_created' => $loadStatus->created_at,
            'load_status_updated' => $loadStatus->updated_at,
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
                'viewed ' . $loadStatus->label . '.',
                $loadStatus->id,
                'cubes',
                'bg-aqua'
            );
        }

        Log::info($logMessage, $logContext);
    }
}