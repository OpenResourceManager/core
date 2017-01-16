<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Campus;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;
use App\Events\Event;

class CampusesViewed extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $campusIds;

    /**
     * CampusesViewed constructor.
     * @param array $campusIds
     */
    public function __construct($campusIds = [])
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            history()->log(
                'Campus',
                'viewed ' . count($campusIds) . ' campuses',
                $user->id,
                'eye',
                'bg-aqua'
            );

        }

        Log::info($user_name . ' viewed ' . count($campusIds) . ' campuses', $campusIds);
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
