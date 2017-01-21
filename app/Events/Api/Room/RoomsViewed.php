<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Room;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;
use App\Events\Event;

class RoomsViewed extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $roomIds;

    /**
     * RoomViewed constructor.
     * @param array $roomIds
     */
    public function __construct($roomIds = [])
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            history()->log(
                'Room',
                'viewed ' . count($roomIds) . ' rooms',
                $user->id,
                'building-o',
                'bg-aqua'
            );

        }

        Log::info($user_name . ' viewed ' . count($roomIds) . ' rooms', $roomIds);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     *
     * public function broadcastOn()
     * {
     * return new PrivateChannel('channel-name');
     * }
     */
}
