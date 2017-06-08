<?php

namespace App\Events\Api\School;

use App\Http\Models\API\School;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class SchoolRestored extends Event
{

    /**
     * SchoolRestored constructor.
     * @param School $loadStatus
     */
    public function __construct(School $loadStatus)
    {
        Log::info('School Restored:', [
            'id' => $loadStatus->id,
            'code' => $loadStatus->code,
            'label' => $loadStatus->label
        ]);

        if ($user = auth()->user()) {

            if (Settings::get('broadcast-events', false)) {

                $loadStatus->campus;

                $data_to_secure = json_encode([
                    'data' => $loadStatus->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'restored',
                    'type' => 'school',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'School',
                'restored a school: ' . $loadStatus->label() . '.',
                $loadStatus->id,
                'university',
                'bg-lime'
            );
        }
    }
}
