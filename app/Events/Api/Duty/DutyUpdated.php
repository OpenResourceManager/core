<?php

namespace App\Events\Api\Duty;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Duty;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class DutyUpdated extends ApiRequestEvent
{

    /**
     * RoomUpdated constructor.
     * @param Duty $duty
     */
    public function __construct(Duty $duty)
    {
        parent::__construct();

        $logMessage = 'updated duty - ';
        $logContext = [
            'action' => 'update',
            'model' => 'duty',
            'duty_id' => $duty->id,
            'duty_code' => $duty->code,
            'duty_label' => $duty->label,
            'duty_created' => $duty->created_at,
            'duty_updated' => $duty->updated_at,
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
                    'data' => $duty->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'updated',
                    'type' => 'duty',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Duty',
                'updated the duty: ' . $duty->label . '.',
                $duty->id,
                'cube',
                'bg-lime'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
