<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Campus;

use Illuminate\Support\Facades\Log;
use App\Events\Event;

class CampusesViewed extends Event
{
    /**
     * CampusesViewed constructor.
     * @param array $campusIds
     */
    public function __construct($campusIds = [])
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

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
