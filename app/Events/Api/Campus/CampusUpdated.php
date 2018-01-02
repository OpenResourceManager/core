<?php

namespace App\Events\Api\Campus;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Campus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class CampusUpdated extends ApiRequestEvent
{

    /**
     * CampusUpdated constructor.
     * @param Campus $campus
     */
    public function __construct(Campus $campus)
    {
        parent::__construct();

        $logMessage = 'updated campus - ';
        $logContext = [
            'action' => 'update',
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

                $data_to_secure = json_encode([
                    'data' => $campus->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'updated',
                    'type' => 'campus',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Campus',
                'updated the campus: ' . $campus->label() . '.',
                $campus->id,
                'university',
                'bg-lime'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
