<?php

namespace App\Events\Api\Campus;

use App\Http\Models\API\Campus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Events\Event;
use Illuminate\Support\Facades\Log;

class CampusViewed extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * DepartmentViewed constructor.
     * @param Campus $campus
     */
    public function __construct(Campus $campus)
    {

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            history()->log(
                'Campus',
                'viewed ' . $campus->label . '.',
                $user->id,
                'university',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $campus->label . '.');
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