<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use App\Http\Models\API\Course;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Events\Event;


class UnassignedCourse extends Event implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $info;

    /**
     * AddressCreated constructor.
     * @param Account $account
     * @param Course $course
     */
    public function __construct(Account $account, Course $course)
    {
        $info = [
            'account_id' => $account->id,
            'identifier' => $account->identifier,
            'username' => $account->username,
            'name' => $account->format_full_name(true),
            'course_id' => $course->id,
            'course_code' => $course->code,
            'course_label' => $course->label
        ];

        Log::info('Account removed from Course:', $info);

        $this->info = json_encode($info);

        if (auth()->user()) {
            history()->log(
                'Assignment',
                'removed ' . $account->format_full_name() . ' from course: "' . $course->label.'"',
                $account->id,
                'graduation-cap',
                'bg-yellow'
            );
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('course-enrollment');
    }
}
