<?php

namespace App\Events\Api\Department;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\Department;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class DepartmentViewed extends ApiRequestEvent
{

    /**
     * DepartmentViewed constructor.
     * @param Department $department
     */
    public function __construct(Department $department)
    {

        parent::__construct();

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