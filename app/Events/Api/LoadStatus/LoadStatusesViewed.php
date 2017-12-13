<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\LoadStatus;

use App\Events\Api\ApiRequestEvent;
use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Log;

class LoadStatusesViewed extends ApiRequestEvent
{
    /**
     * LoadStatusesViewed constructor.
     * @param array $loadStatusIds
     */
    public function __construct($loadStatusIds = [])
    {
        parent::__construct();

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'LoadStatus',
                'viewed ' . count($loadStatusIds) . ' load statuses',
                $user->id,
                'cubes',
                'bg-aqua'
            );

        }

        Log::info($user_name . ' viewed ' . count($loadStatusIds) . ' schools', $loadStatusIds);
    }
}
