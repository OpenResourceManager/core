<?php

namespace App\Events\Api\Duty;

use App\Events\Event;
use App\Http\Models\API\Duty;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class DutyUpdated extends Event
{

    /**
     * RoomUpdated constructor.
     * @param Duty $duty
     */
    public function __construct(Duty $duty)
    {
        Log::info('Duty Updated:', [
            'id' => $duty->id,
            'code' => $duty->code,
            'label' => $duty->label
        ]);

        if ($user = auth()->user()) {

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
                'updated the duty: ' . $duty->label() . '.',
                $duty->id,
                'cube',
                'bg-lime'
            );
        }
    }
}
