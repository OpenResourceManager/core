<?php

namespace App\Events\Api\Department;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Department;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class DepartmentDestroyed extends ApiRequestEvent
{
    /**
     * DepartmentDestroyed constructor.
     * @param Department $department
     */
    public function __construct(Department $department)
    {
        parent::__construct();

        Log::info('Department Destroyed:', [
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
                    'event' => 'deleted',
                    'type' => 'department',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Department',
                'destroyed a department: ' . $department->label,
                $department->id,
                'cubes',
                'bg-red'
            );
        }
    }
}
