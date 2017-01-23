<?php

namespace App\Events\Api\Building;

use App\Http\Models\API\Building;
use App\Events\Event;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class BuildingViewed extends Event
{
    /**
     * BuildingViewed constructor.
     * @param Building $building
     */
    public function __construct(Building $building)
    {

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'Building',
                'viewed ' . $building->label . '.',
                $building->id,
                'building',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $building->label . '.');
    }
}