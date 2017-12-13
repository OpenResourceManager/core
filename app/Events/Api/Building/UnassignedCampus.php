<?php

namespace App\Events\Api\Building;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Building;
use App\Http\Models\API\Campus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class UnassignedCampus extends ApiRequestEvent
{

    /**
     * UnassignedCampus constructor.
     * @param Building $building
     * @param Campus $campus
     */
    public function __construct(Building $building, Campus $campus)
    {
        parent::__construct();

        $info = [
            'building_id' => $building->id,
            'building_code' => $building->code,
            'building_label' => $building->label,
            'campus_id' => $campus->id,
            'campus_code' => $campus->code,
            'campus_label' => $campus->label
        ];

        Log::info('Building unassigned Campus:', $info);

        if ($user = auth()->user()) {

            if (Settings::get('broadcast-events', false)) {

                $data_to_secure = json_encode([
                    'data' => [
                        'building' => $building->toArray(),
                        'campus' => $campus->toArray()
                    ],
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'unassigned',
                    'type' => 'campus',
                    'to' => 'building',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Assignment',
                'removed ' . $building->label . ' from campus: "' . $campus->label . '"',
                $building->id,
                'university',
                'bg-yellow'
            );
        }
    }
}
