<?php

namespace App\Events\Api\Campus;

use App\Http\Models\API\Campus;
use App\Events\Event;
use Illuminate\Support\Facades\Log;

class CampusViewed extends Event
{
    /**
     * DepartmentViewed constructor.
     * @param Campus $campus
     */
    public function __construct(Campus $campus)
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

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