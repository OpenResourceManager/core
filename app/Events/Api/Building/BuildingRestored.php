<?php

namespace App\Events\Api\Building;

use App\Http\Models\API\Building;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class BuildingRestored extends Event
{

    public function __construct(Building $building)
    {
        if (auth()->user()) {

            Log::info('Building Restored:', [
                'id' => $building->id,
                'code' => $building->code,
                'label' => $building->label
            ]);

            $building->campus;

            $data_to_secure = json_encode([
                'data' => $building->toArray(),
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'restored',
                'type' => 'building',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Building',
                'restored a building: ' . $building->label() . '.',
                $building->id,
                'building',
                'bg-lime'
            );
        }
    }
}
