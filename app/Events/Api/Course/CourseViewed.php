<?php

namespace App\Events\Api\Course;

use App\Http\Models\API\Course;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Events\Event;
use Illuminate\Support\Facades\Log;

class CourseViewed extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * DepartmentViewed constructor.
     * @param Course $course
     */
    public function __construct(Course $course)
    {

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            history()->log(
                'Course',
                'viewed ' . $course->label . '.',
                $user->id,
                'graduation-cap',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $course->label . '.');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     *
     * public function broadcastOn()
     * {
     * return new PrivateChannel('channel-name');
     * }
     */
}