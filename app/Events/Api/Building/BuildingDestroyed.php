<?php

namespace App\Events\Api\Building;

use App\Http\Models\API\Building;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;

class BuildingDestroyed extends Event
{
    /**
     * BuildingDestroyed constructor.
     * @param Building $building
     */
    public function __construct(Building $building)
    {
        Log::info('Building Deleted:', [
            'id' => $building->id,
            'code' => $building->code,
            'label' => $building->label
        ]);

        if ($user = auth()->user()) {

            $building->campus;

            $data_to_secure = json_encode([
                'data' => $building->toArray(),
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'deleted',
                'type' => 'building',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Building',
                'destroyed a building: ' . $building->label,
                $building->id,
                'building',
                'bg-red'
            );
        }
    }
}
