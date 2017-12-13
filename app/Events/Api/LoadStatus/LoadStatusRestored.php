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
     * @param LoadStatus $loadStatus
     */
    public function __construct(LoadStatus $loadStatus)
    {
        parent::__construct();

        Log::info('Load Status Restored:', [
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
                    'type' => 'load-status',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'LoadStatus',
                'restored a load status: ' . $loadStatus->label() . '.',
                $loadStatus->id,
                'cubes',
                'bg-lime'
            );
        }
    }
}
