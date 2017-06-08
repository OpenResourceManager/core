<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Building;

use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Krucas\Settings\Facades\Settings;

class BuildingsViewed extends Event
{
    /**
     * BuildingsViewed constructor.
     * @param array $buildingIds
     */
    public function __construct($buildingIds = [])
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'Building',
                'viewed ' . count($buildingIds) . ' buildings',
                $user->id,
                'building',
                'bg-aqua'
            );

        }

        Log::info($user_name . ' viewed ' . count($buildingIds) . ' buildings', $buildingIds);
    }
}