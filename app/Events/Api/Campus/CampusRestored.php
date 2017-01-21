<?php

namespace App\Events\Api\Campus;

use App\Http\Models\API\Campus;
use Illuminate\Broadcasting\Channel;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class CampusRestored extends Event
{
    /**
     * CampusRestored constructor.
     * @param Campus $campus
     */
    public function __construct(Campus $campus)
    {
        if (auth()->user()) {

            Log::info('Campus Restored:', [
                'id' => $campus->id,
                'code' => $campus->code,
                'label' => $campus->label
            ]);

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

            history()->log(
                'Campus',
                'restored a campus: ' . $campus->label() . '.',
                $campus->id,
                'university',
                'bg-lime'
            );
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
//    public function broadcastOn()
//    {
//        return new PrivateChannel('account-events');
//    }
}
