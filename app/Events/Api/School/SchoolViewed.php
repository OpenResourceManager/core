<?php

namespace App\Events\Api\School;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\School;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class SchoolViewed extends ApiRequestEvent
{
    /**
     * SchoolViewed constructor.
     * @param School $school
     */
    public function __construct(School $school)
    {

        parent::__construct();

        $logMessage = 'viewed school - ';
        $logContext = [
            'action' => 'view',
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

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'School',
                'viewed ' . $school->label . '.',
                $school->id,
                'university',
                'bg-aqua'
            );
        }

        Log::info($logMessage, $logContext);
    }
}