<?php

namespace App\Events\Api\Duty;

use App\Http\Models\API\Duty;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Events\Event;
use Illuminate\Support\Facades\Log;

class DutyViewed extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * DutyViewed constructor.
     * @param Duty $duty
     */
    public function __construct(Duty $duty)
    {

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            history()->log(
                'Duty',
                'viewed ' . $duty->label . '.',
                $user->id,
                'cube',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $duty->label . '.');
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