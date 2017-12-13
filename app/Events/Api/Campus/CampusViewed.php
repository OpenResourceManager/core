<?php

namespace App\Events\Api\Campus;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Campus;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class CampusViewed extends ApiRequestEvent
{
    /**
     * DepartmentViewed constructor.
     * @param Campus $campus
     */
    public function __construct(Campus $campus)
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
                'viewed ' . $campus->label . '.',
                $campus->id,
                'university',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $campus->label . '.');
    }
}