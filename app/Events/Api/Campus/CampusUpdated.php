<?php

namespace App\Events\Api\Building;

use App\Events\Event;
use App\Http\Models\API\Campus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CampusUpdated extends Event
{

    /**
     * CampusUpdated constructor.
     * @param Campus $campus
     */
    public function __construct(Campus $campus)
    {
        Log::info('Campus Updated:', [
            'id' => $campus->id,
            'code' => $campus->code,
            'label' => $campus->label
        ]);

        if ($user = auth()->user()) {

            $data_to_secure = json_encode([
                'data' => $campus->toArray(),
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'updated',
                'type' => 'campus',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Campus',
                'updated the campus: ' . $campus->label() . '.',
                $campus->id,
                'university',
                'bg-lime'
            );
        }
    }
}
