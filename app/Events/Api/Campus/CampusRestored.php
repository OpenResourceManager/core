<?php

namespace App\Events\Api\Campus;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Campus;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class CampusRestored extends ApiRequestEvent
{
    /**
     * CampusRestored constructor.
     * @param Campus $campus
     */
    public function __construct(Campus $campus)
    {
        parent::__construct();

        Log::info('Campus Restored:', [
            'id' => $campus->id,
            'code' => $campus->code,
            'label' => $campus->label
        ]);

        if ($user = auth()->user()) {

            if (Settings::get('broadcast-events', false)) {

                $campus->campus;

                $data_to_secure = json_encode([
                    'data' => $campus->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'restored',
                    'type' => 'campus',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Campus',
                'restored a campus: ' . $campus->label() . '.',
                $campus->id,
                'university',
                'bg-lime'
            );
        }
    }
}
