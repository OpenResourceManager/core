<?php

namespace App\Events\Api\School;

use App\Http\Models\API\School;
use App\Events\Event;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class SchoolViewed extends Event
{
    /**
     * SchoolViewed constructor.
     * @param School $school
     */
    public function __construct(School $school)
    {

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'School',
                'viewed ' . $school->label . '.',
                $school->id,
                'university',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $school->label . '.');
    }
}