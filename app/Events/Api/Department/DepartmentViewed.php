<?php

namespace App\Events\Api\Department;

use App\Http\Models\API\Department;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Events\Event;
use Illuminate\Support\Facades\Log;

class DepartmentViewed extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * DepartmentViewed constructor.
     * @param Department $department
     */
    public function __construct(Department $department)
    {

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            history()->log(
                'Department',
                'viewed ' . $department->label . '.',
                $user->id,
                'cubes',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $department->label . '.');
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