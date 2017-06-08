<?php

namespace App\Events\Api\LoadStatus;

use App\Http\Models\API\LoadStatus;
use App\Events\Event;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class LoadStatusViewed extends Event
{
    /**
     * LoadStatusViewed constructor.
     * @param LoadStatus $loadStatus
     */
    public function __construct(LoadStatus $loadStatus)
    {

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'LoadStatus',
                'viewed ' . $loadStatus->label . '.',
                $loadStatus->id,
                'fa-university',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $loadStatus->label . '.');
    }
}