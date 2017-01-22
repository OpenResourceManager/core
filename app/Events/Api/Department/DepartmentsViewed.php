<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/16/17
 * Time: 4:37 PM
 */

namespace App\Events\Api\Department;

use Illuminate\Support\Facades\Log;
use App\Events\Event;

class DepartmentsViewed extends Event
{

    /**
     * DepartmentsViewed constructor.
     * @param array $departmentIds
     */
    public function __construct($departmentIds = [])
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

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
