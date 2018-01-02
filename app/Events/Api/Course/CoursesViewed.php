<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Course;

use App\Events\Api\ApiRequestEvent;
use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Log;

class CoursesViewed extends ApiRequestEvent
{
    /**
     * CoursesViewed constructor.
     * @param array $courseIds
     */
    public function __construct($courseIds = [])
    {
        parent::__construct();

        $logMessage = 'viewed courses - ';
        $logContext = [
            'action' => 'view',
            'model' => 'course',
            'course_ids' => $courseIds,
            'course_id_count' => count($courseIds),
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
                // @todo bc view event
            }

            history()->log(
                'Course',
                'viewed ' . count($courseIds) . ' courses',
                $user->id,
                'graduation-cap',
                'bg-aqua'
            );

        }

        Log::info($logMessage, $logContext);
    }
}
