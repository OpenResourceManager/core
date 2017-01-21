<?php

namespace App\Events\Api\Building;

use App\Http\Models\API\Building;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Events\Event;
use Illuminate\Support\Facades\Log;

class BuildingViewed extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * BuildingViewed constructor.
     * @param Building $building
     */
    public function __construct(Building $building)
    {

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            history()->log(
                'Building',
                'viewed ' . $building->label . '.',
                $user->id,
                'building',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $building->label . '.');
    }
}