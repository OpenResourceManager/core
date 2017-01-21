<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use App\Http\Models\API\Department;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;


class AssignedDepartment extends Event
{

    /**
     * AddressCreated constructor.
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

            Log::info('Account assigned Department:', $info);

            $account->primary_duty = $account->primaryDuty;
            $trans = $account->toArray();
            $trans['name_full'] = $account->format_full_name(true);
            unset($trans['password']);
            $trans['username'] = strtolower($trans['username']);

            $data_to_secure = json_encode([
                'data' => [
                    'account' => $account,
                    'department' => $department->toArray()
                ],
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'assigned',
                'type' => 'department',
                'to' => 'account',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Assignment',
                'assigned ' . $account->format_full_name() . ' to department: "' . $department->label . '"',
                $account->id,
                'cubes',
                'bg-olive'
            );
        }
    }
}
