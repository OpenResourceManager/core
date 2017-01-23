<?php

namespace App\Events\Api\Department;

use App\Http\Models\API\Department;
use App\Events\Event;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class DepartmentViewed extends Event
{

    /**
     * DepartmentViewed constructor.
     * @param Department $department
     */
    public function __construct(Department $department)
    {

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'Department',
                'viewed ' . $department->label . '.',
                $department->id,
                'cubes',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $department->label . '.');
    }
}