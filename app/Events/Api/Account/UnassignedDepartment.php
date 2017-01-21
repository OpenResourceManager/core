<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use App\Http\Models\API\Department;
use Illuminate\Support\Facades\Log;
use App\Events\Event;


class UnassignedDepartment extends Event
{


    /**
     * UnassignedDepartment constructor.
     * @param Account $account
     * @param Department $department
     */
    public function __construct(Account $account, Department $department)
    {
        if (auth()->user()) {

            $info = [
                'account_id' => $account->id,
                'identifier' => $account->identifier,
                'username' => $account->username,
                'name' => $account->format_full_name(true),
                'department_id' => $department->id,
                'department_code' => $department->code,
                'department_label' => $department->label
            ];

            Log::info('Account unassigned Department:', $info);

            $this->info = json_encode($info);

            history()->log(
                'Assignment',
                'unassigned ' . $account->format_full_name() . ' from department: "' . $department->label . '"',
                $account->id,
                'cubes',
                'bg-yellow'
            );
        }
    }
}
