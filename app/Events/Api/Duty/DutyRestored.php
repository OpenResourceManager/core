<?php

namespace App\Events\Api\Duty;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Duty;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class DutyRestored extends ApiRequestEvent
{

    /**
     * DutyRestored constructor.
     * @param Duty $duty
     */
    public function __construct(Duty $duty)
    {
        parent::__construct();

        Log::info('Duty Restored:', [
            'id' => $duty->id,
            'code' => $duty->code,
            'label' => $duty->label
        ]);

        if ($user = auth()->user()) {

            if (Settings::get('broadcast-events', false)) {

                $duty->campus;

                $data_to_secure = json_encode([
                    'data' => $duty->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'restored',
                    'type' => 'duty',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Duty',
                'restored a duty: ' . $duty->label() . '.',
                $duty->id,
                'cube',
                'bg-lime'
            );
        }
    }
}
