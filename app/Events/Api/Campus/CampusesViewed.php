<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Campus;

use App\Events\Api\ApiRequestEvent;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class CampusesViewed extends ApiRequestEvent
{
    /**
     * CampusesViewed constructor.
     * @param array $campusIds
     */
    public function __construct($campusIds = [])
    {
        parent::__construct();

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'Campus',
                'viewed ' . count($campusIds) . ' campuses',
                $user->id,
                'university',
                'bg-aqua'
            );
        }
        Log::info($user_name . ' viewed ' . count($campusIds) . ' campuses', $campusIds);
    }
}
