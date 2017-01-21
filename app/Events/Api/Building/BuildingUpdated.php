<?php

namespace App\Events\Api\Building;

use App\Events\Event;
use App\Http\Models\API\Building;
use Illuminate\Support\Facades\Log;

class BuildingUpdated extends Event
{


    public function __construct(Building $building)
    {
        Log::info('Building Updated:', [
            'id' => $building->id,
            'code' => $building->code,
            'label' => $building->label
        ]);

        if (auth()->user()) {

            $building->campus;

            $data_to_secure = json_encode([
                'data' => $building->toArray(),
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'updated',
                'type' => 'building',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Building',
                'updated the building: ' . $building->label() . '.',
                $building->id,
                'building',
                'bg-lime'
            );
        }
    }
}
