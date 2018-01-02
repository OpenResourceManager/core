<?php

namespace App\Events\Api\Campus;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Campus;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class CampusViewed extends ApiRequestEvent
{
    /**
     * DepartmentViewed constructor.
     * @param Campus $campus
     */
    public function __construct(Campus $campus)
    {
        parent::__construct();

        $logMessage = 'viewed campus - ';
        $logContext = [
            'action' => 'view',
            'model' => 'campus',
            'campus_id' => $campus->id,
            'campus_code' => $campus->code,
            'campus_label' => $campus->label,
            'campus_created' => $campus->created_at,
            'campus_updated' => $campus->updated_at,
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
                'Campus',
                'viewed ' . $campus->label . '.',
                $campus->id,
                'university',
                'bg-aqua'
            );
        }

        Log::info($logMessage, $logContext);
    }
}