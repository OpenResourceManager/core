<?php

namespace App\Events\Api\LoadStatus;

use App\Http\Models\API\LoadStatus;
use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;

class LoadStatusDestroyed extends Event
{
    /**
     * LoadStatusDestroyed constructor.
     * @param LoadStatus $loadStatus
     */
    public function __construct(LoadStatus $loadStatus)
    {
        Log::info('Load Status Destroyed:', [
            'id' => $loadStatus->id,
            'code' => $loadStatus->code,
            'label' => $loadStatus->label
        ]);

        if ($user = auth()->user()) {

            if (Settings::get('broadcast-events', false)) {

                $data_to_secure = json_encode([
                    'data' => $loadStatus->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'deleted',
                    'type' => 'load-status',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'LoadStatus',
                'destroyed a load status: ' . $loadStatus->label,
                $loadStatus->id,
                'fa-university',
                'bg-red'
            );
        }
    }
}
