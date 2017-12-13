<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Department;

use App\Events\Api\ApiRequestEvent;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class DepartmentsViewed extends ApiRequestEvent
{

    /**
     * DepartmentsViewed constructor.
     * @param array $departmentIds
     */
    public function __construct($departmentIds = [])
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
                'viewed ' . count($departmentIds) . ' departments',
                $user->id,
                'cubes',
                'bg-aqua'
            );

        }

        Log::info($user_name . ' viewed ' . count($departmentIds) . ' departments', $departmentIds);
    }
}
