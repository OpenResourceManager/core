<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Duty;

use Illuminate\Support\Facades\Log;
use App\Events\Event;

class DutiesViewed extends Event
{
    /**
     * DutiesViewed constructor.
     * @param array $dutyIds
     */
    public function __construct($dutyIds = [])
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

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
