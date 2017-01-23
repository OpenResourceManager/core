<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use App\Http\Models\API\Course;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;


class UnassignedCourse extends Event
{
    /**
     * UnassignedCourse constructor.
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

        if ($user = auth()->user()) {

            if (Settings::get('broadcast-events', false)) {

                $account->primary_duty = $account->primaryDuty;
                $trans = $account->toArray();
                $trans['name_full'] = $account->format_full_name(true);
                unset($trans['password']);
                $trans['username'] = strtolower($trans['username']);

                $data_to_secure = json_encode([
                    'data' => [
                        'account' => $account,
                        'course' => $course->toArray()
                    ],
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'unassigned',
                    'type' => 'course',
                    'to' => 'account',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Assignment',
                'removed ' . $account->format_full_name() . ' from course: "' . $course->label . '"',
                $account->id,
                'graduation-cap',
                'bg-yellow'
            );
        }
    }
}
