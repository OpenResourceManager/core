<?php

namespace App\Events\Api\Room;

use App\Http\Models\API\Room;
use App\Events\Event;
use Illuminate\Support\Facades\Log;

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

            history()->log(
                'Room',
                'viewed ' . $room->label . '.',
                $room->id,
                'building-o',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $room->label . '.');
    }
}