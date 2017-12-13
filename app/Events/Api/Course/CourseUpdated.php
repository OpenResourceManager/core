<?php

namespace App\Events\Api\Course;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Course;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;

class CourseUpdated extends ApiRequestEvent
{
    /**
     * CourseUpdated constructor.
     * @param Course $course
     */
    public function __construct(Course $course)
    {
        parent::__construct();

        Log::info('Course Updated:', [
            'id' => $course->id,
            'code' => $course->code,
            'label' => $course->label
        ]);

        if ($user = auth()->user()) {

            if (Settings::get('broadcast-events', false)) {

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
            }

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
