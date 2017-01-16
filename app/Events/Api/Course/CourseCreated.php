<?php

namespace App\Events\Api\Course;

use App\Http\Models\API\Course;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;

class CourseCreated extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Course $course)
    {
        Log::info('Course Created:', [
            'id' => $course->id,
            'code' => $course->code,
            'label' => $course->label
        ]);

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


        if (auth()->user()) {
            history()->log(
                'Course',
                'created a new course: ' . $course->label,
                $course->id,
                'graduation-cap',
                'bg-green'
            );
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    #public function broadcastOn()
    #{
    #    return new PrivateChannel('channel-name');
    #}
}
