<?php

namespace App\Events\Api\Campus;

use App\Http\Models\API\Campus;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class CampusCreated extends Event
{

    /**
     * CampusCreated constructor.
     * @param Campus $campus
     */
    public function __construct(Campus $campus)
    {
        Log::info('Campus Created:', [
            'id' => $campus->id,
            'code' => $campus->code,
            'label' => $campus->label
        ]);

        if ($user = auth()->user()) {

            if (Settings::get('broadcast-events', false)) {

                $data_to_secure = json_encode([
                    'data' => $campus->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'created',
                    'type' => 'campus',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Campus',
                'created a new campus: ' . $campus->label,
                $campus->id,
                'university',
                'bg-green'
            );
        }
    }
}
