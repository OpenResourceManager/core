<?php

namespace App\Events\Api\Account;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Account;
use App\Http\Models\API\Course;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;


class UnassignedCourse extends ApiRequestEvent
{
    /**
     * UnassignedCourse constructor.
     * @param Account $account
     * @param Course $course
     */
    public function __construct(Account $account, Course $course)
    {
        parent::__construct();

        $logMessage = 'unassigned account from course - ';
        $logContext = [
            'action' => 'unassignment',
            'model' => 'account',
            'pivot' => 'course',
            'account_id' => $account->id,
            'account_identifier' => $account->identifier,
            'account_username' => $account->username,
            'account_name_first' => $account->name_first,
            'account_name_last' => $account->name_last,
            'account_name' => $account->format_full_name(true),
            'account_created' => $account->created_at,
            'account_updated' => $account->updated_at,
            'course_id' => $course->id,
            'course_code' => $course->code,
            'course_label' => $course->label,
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

        Log::info($logMessage, $logContext);
    }
}
