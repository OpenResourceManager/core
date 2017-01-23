<?php

namespace App\Events\Api\Department;

use App\Http\Models\API\Department;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class DepartmentCreated extends Event
{
    /**
     * DepartmentCreated constructor.
     * @param Department $department
     */
    public function __construct(Department $department)
    {
        Log::info('Department Created:', [
            'id' => $department->id,
            'code' => $department->code,
            'label' => $department->label
        ]);

        if ($user = auth()->user()) {

            if (Settings::get('broadcast-events', false)) {

                $data_to_secure = json_encode([
                    'data' => $department->toArray(),
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'created',
                    'type' => 'department',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Department',
                'created a new department: ' . $department->label,
                $department->id,
                'cubes',
                'bg-green'
            );
        }
    }
}
