<?php

namespace App\Events\Api\Department;

use App\Http\Models\API\Department;
use Illuminate\Broadcasting\Channel;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class DepartmentRestored extends Event
{

    /**
     * DepartmentRestored constructor.
     * @param Department $department
     */
    public function __construct(Department $department)
    {
        if (auth()->user()) {

            Log::info('Department Restored:', [
                'id' => $department->id,
                'code' => $department->code,
                'label' => $department->label
            ]);

            $department->campus;

            $data_to_secure = json_encode([
                'data' => $department->toArray(),
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'restored',
                'type' => 'department',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Department',
                'restored a department: ' . $department->label() . '.',
                $department->id,
                'cubes',
                'bg-lime'
            );
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
//    public function broadcastOn()
//    {
//        return new PrivateChannel('account-events');
//    }
}
