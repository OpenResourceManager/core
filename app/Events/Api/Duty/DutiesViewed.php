<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Duty;

use App\Events\Api\ApiRequestEvent;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class DutiesViewed extends ApiRequestEvent
{
    /**
     * DutiesViewed constructor.
     * @param array $dutyIds
     */
    public function __construct($dutyIds = [])
    {
        parent::__construct();

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'Duty',
                'viewed ' . count($dutyIds) . ' duties',
                $user->id,
                'cube',
                'bg-aqua'
            );
        }
        Log::info($user_name . ' viewed ' . count($dutyIds) . ' duties', $dutyIds);
    }
}
