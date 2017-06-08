<?php

namespace App\Events\Api\Course;

use App\Http\Models\API\Course;
use App\Events\Event;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class CourseViewed extends Event
{
    /**
     * DepartmentViewed constructor.
     * @param Course $course
     */
    public function __construct(Course $course)
    {

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'Course',
                'viewed ' . $course->label . '.',
                $course->id,
                'graduation-cap',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $course->label . '.');
    }
}