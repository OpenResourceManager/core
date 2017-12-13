<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Building;

use App\Events\Api\ApiRequestEvent;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class BuildingsViewed extends ApiRequestEvent
{
    /**
     * BuildingsViewed constructor.
     * @param array $buildingIds
     */
    public function __construct($buildingIds = [])
    {
        parent::__construct();

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
