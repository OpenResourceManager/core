<?php

namespace App\Events\Api\Room;

use App\Http\Models\API\Room;
use App\Events\Event;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class RoomViewed extends Event
{

    /**
     * RoomViewed constructor.
     * @param Room $room
     */
    public function __construct(Room $room)
    {

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'Room',
                'viewed ' . (empty($room->label)) ? $room->code : $room->label . '.',
                $room->id,
                'building-o',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . (empty($room->label)) ? $room->code : $room->label . '.');
    }
}