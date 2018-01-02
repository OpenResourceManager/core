<?php

namespace App\Events\Api\Course;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Department;
use App\Http\Models\API\Course;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;


class UnassignedDepartment extends ApiRequestEvent
{

    /**
     * UnassignedDepartment constructor.
     * @param Course $course
     * @param Department $department
     */
    public function __construct(Course $course, Department $department)
    {
        parent::__construct();

        $logMessage = 'unassigned course from department - ';
        $logContext = [
            'action' => 'unassignment',
            'model' => 'course',
            'pivot' => 'department',
            'course_id' => $course->id,
            'course_code' => $course->code,
            'course_label' => $course->label,
            'department_id' => $department->id,
            'department_code' => $department->code,
            'department_label' => $department->label,
            'course_created' => $course->created_at,
            'course_updated' => $course->updated_at,
            'requester_id' => 0,
            'requester_name' => 'System',
            'requester_ip' => getRequestIP(),
            'request_proxy_ip' => getRequestIP(true),
            'request_method' => \Request::getMethod(),
            'request_url' => \Request::fullUrl(),
            'request_uri' => \Request::getRequestUri(),
            'request_scheme' => \Request::getScheme(),
            'request_host' => \Request::getHost()
        ];

        if ($user = auth()->user()) {

            $logMessage = auth()->user()->name . ' ' . $logMessage;
            $logContext['requester_id'] = auth()->user()->id;
            $logContext['requester_name'] = auth()->user()->name;

            if (Settings::get('broadcast-events', false)) {

                $data_to_secure = json_encode([
                    'data' => [
                        'course' => $course->toArray(),
                        'department' => $department->toArray()
                    ],
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'unassigned',
                    'type' => 'department',
                    'to' => 'course',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Assignment',
                'assigned course: ' . $course->label . ' to department: "' . $department->label . '"',
                $course->id,
                'cubes',
                'bg-yellow'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
