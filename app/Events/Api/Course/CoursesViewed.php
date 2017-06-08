<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Course;

use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Log;
use App\Events\Event;

class CoursesViewed extends Event
{
    /**
     * CoursesViewed constructor.
     * @param array $courseIds
     */
    public function __construct($courseIds = [])
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

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

        Log::info($user_name . ' viewed ' . count($courseIds) . ' courses', $courseIds);
    }
}