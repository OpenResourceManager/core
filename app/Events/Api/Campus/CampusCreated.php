<?php

namespace App\Events\Api\Campus;

use App\Http\Models\API\Campus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;

class CampusCreated extends Event
{

    /**
     * CampusCreated constructor.
     * @param Campus $campus
     */
    public function __construct(Campus $campus)
    {
        if (auth()->user()) {

            Log::info('Campus Created:', [
                'id' => $campus->id,
                'code' => $campus->code,
                'label' => $campus->label
            ]);

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

            history()->log(
                'Campus',
                'created a new campus: ' . $campus->label,
                $campus->id,
                'university',
                'bg-green'
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
//        return new PrivateChannel('channel-name');
//    }
}
