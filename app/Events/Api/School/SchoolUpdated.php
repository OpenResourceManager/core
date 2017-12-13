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

        Log::info('School Updated:', [
            'id' => $school->id,
            'code' => $school->code,
            'label' => $school->label
        ]);

        if ($user = auth()->user()) {

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
                'updated the school: ' . $school->label() . '.',
                $school->id,
                'university',
                'bg-lime'
            );
        }
    }
}
