<?php

namespace App\Events\Api\School;

use App\Http\Models\API\School;
use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;

class SchoolDestroyed extends Event
{
    /**
     * SchoolDestroyed constructor.
     * @param School $school
     */
    public function __construct(School $school)
    {
        Log::info('School Destroyed:', [
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
                    'event' => 'deleted',
                    'type' => 'school',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'School',
                'destroyed a school: ' . $school->label,
                $school->id,
                'university',
                'bg-red'
            );
        }
    }
}
