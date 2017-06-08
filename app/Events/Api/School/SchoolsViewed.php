<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\School;

use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Log;
use App\Events\Event;

class SchoolsViewed extends Event
{
    /**
     * SchoolsViewed constructor.
     * @param array $schoolIds
     */
    public function __construct($schoolIds = [])
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'School',
                'viewed ' . count($schoolIds) . ' schools',
                $user->id,
                'university',
                'bg-aqua'
            );

        }

        Log::info($user_name . ' viewed ' . count($schoolIds) . ' schools', $schoolIds);
    }
}
