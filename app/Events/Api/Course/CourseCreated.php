<?php

namespace App\Events\Api\Course;

use App\Http\Models\API\Course;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;

class CourseCreated extends Event
{
    /**
     * CourseCreated constructor.
     * @param Course $course
     */
    public function __construct(Course $course)
    {
        Log::info('Course Created:', [
            'id' => $course->id,
            'code' => $course->code,
            'label' => $course->label
        ]);

        if ($user = auth()->user()) {

            $course->department;

            $data_to_secure = json_encode([
                'data' => $course->toArray(),
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'created',
                'type' => 'course',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Course',
                'created a new course: ' . $course->label,
                $course->id,
                'graduation-cap',
                'bg-green'
            );
        }
    }
}
