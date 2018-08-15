<?php

namespace App\Events\Api\LoadStatus;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\LoadStatus;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class LoadStatusRestored extends ApiRequestEvent
{

    /**
     * LoadStatusRestored constructor.
     * @param LoadStatus $school
     */
    public function __construct(LoadStatus $school)
    {
        parent::__construct();

        $logMessage = 'restored load status - ';
        $logContext = [
            'action' => 'restore',
            'model' => 'load_status',
            'load_status_id' => $school->id,
            'load_status_code' => $school->code,
            'load_status_label' => $school->label,
            'load_status_created' => $school->created_at,
            'load_status_updated' => $school->updated_at,
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

                $school->campus;

                $data_to_secure = json_encode([
                    'data' => $school->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'restored',
                    'type' => 'load-status',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'LoadStatus',
                'restored a load status: ' . $school->label . '.',
                $school->id,
                'cubes',
                'bg-lime'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
