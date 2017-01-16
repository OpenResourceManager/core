<?php

namespace App\Events\Api\Department;

use App\Http\Models\API\Department;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;

class DepartmentDestroyed extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Department $department)
    {
        Log::info('Department Destroyed:', [
            'id' => $department->id,
            'code' => $department->code,
            'label' => $department->label
        ]);

        $data_to_secure = json_encode([
            'data' => $department->toArray(),
            'conf' => [
                'ldap' => ldap_config()
            ]
        ]);

        $secure_data = encrypt_broadcast_data($data_to_secure);

        $message = [
            'event' => 'deleted',
            'type' => 'department',
            'encrypted' => $secure_data
        ];

        Redis::publish('events', json_encode($message));

        if (auth()->user()) {
            history()->log(
                'Department',
                'destroyed a department: ' . $department,
                $department->id,
                'cubes',
                'bg-red'
            );
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    #public function broadcastOn()
    #{
    #    return new PrivateChannel('channel-name');
    #}
}
