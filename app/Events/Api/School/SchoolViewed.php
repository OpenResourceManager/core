<?php

namespace App\Events\Api\School;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\School;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class SchoolViewed extends ApiRequestEvent
{
    /**
     * SchoolViewed constructor.
     * @param School $school
     */
    public function __construct(School $school)
    {

        parent::__construct();

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