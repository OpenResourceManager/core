<?php

namespace App\Events\Api\Course;

use App\Http\Models\API\Department;
use App\Http\Models\API\Course;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;


class AssignedDepartment extends Event
{

    /**
     * AssignedDepartment constructor.
     * @param Course $course
     * @param Department $department
     */
    public function __construct(Course $course, Department $department)
    {
        $info = [
            'course_id' => $course->id,
            'course_code' => $course->code,
            'course_label' => $course->label,
            'department_id' => $department->id,
            'department_code' => $department->code,
            'department_label' => $department->label
        ];

        Log::info('Course assigned to Department:', $info);

        if ($user = auth()->user()) {

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
                    'event' => 'assigned',
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
                'bg-olive'
            );
        }
    }
}
