<?php

namespace App\Events\Api\School;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\School;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class SchoolUpdated extends ApiRequestEvent
{
    /**
     * SchoolUpdated constructor.
     * @param School $school
     */
    public function __construct(School $school)
    {
        parent::__construct();

        $logMessage = 'updated school - ';
        $logContext = [
            'action' => 'update',
            'model' => 'school',
            'school_id' => $school->id,
            'school_code' => $school->code,
            'school_label' => $school->label,
            'school_created' => $school->created_at,
            'school_updated' => $school->updated_at,
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
                    'data' => $school->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'updated',
                    'type' => 'school',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'School',
                'updated the school: ' . $school->label . '.',
                $school->id,
                'university',
                'bg-lime'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
