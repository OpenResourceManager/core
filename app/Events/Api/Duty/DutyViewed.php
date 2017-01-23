<?php

namespace App\Events\Api\Duty;

use App\Http\Models\API\Duty;
use App\Events\Event;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class DutyViewed extends Event
{
    /**
     * DutyViewed constructor.
     * @param Duty $duty
     */
    public function __construct(Duty $duty)
    {

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'Duty',
                'viewed ' . $duty->label . '.',
                $duty->id,
                'cube',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $duty->label . '.');
    }
}