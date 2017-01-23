<?php

namespace App\Events\Api\Course;

use App\Events\Event;
use App\Http\Models\API\Course;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CourseUpdated extends Event
{
    /**
     * RoomUpdated constructor.
     * @param Course $course
     */
    public function __construct(Course $course)
    {
        Log::info('Course Updated:', [
            'id' => $course->id,
            'code' => $course->code,
            'label' => $course->label
        ]);

        if ($user = auth()->user()) {

            $data_to_secure = json_encode([
                'data' => $course->toArray(),
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'updated',
                'type' => 'course',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Course',
                'updated the course: ' . $course->label() . '.',
                $course->id,
                'graduation-cap',
                'bg-lime'
            );
        }
    }
}
