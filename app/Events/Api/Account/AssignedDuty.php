<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use App\Http\Models\API\Duty;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;


class AssignedDuty extends Event
{
    /**
     * AssignedDuty constructor.
     * @param Account $account
     * @param Duty $duty
     */
    public function __construct(Account $account, Duty $duty)
    {
        $info = [
            'account_id' => $account->id,
            'identifier' => $account->identifier,
            'username' => strtolower($account->username),
            'name' => $account->format_full_name(true),
            'duty_id' => $duty->id,
            'duty_code' => $duty->code,
            'duty_label' => $duty->label
        ];

        Log::info('Account assigned Duty:', $info);

        if (auth()->user()) {

            $account->primary_duty = $account->primaryDuty;
            $trans = $account->toArray();
            $trans['name_full'] = $account->format_full_name(true);
            unset($trans['password']);
            $trans['username'] = strtolower($trans['username']);

            $data_to_secure = json_encode([
                'data' => [
                    'account' => $account,
                    'duty' => $duty->toArray()
                ],
                'conf' => [
                    'ldap' => ldap_config()
                ]
            ]);

            $secure_data = encrypt_broadcast_data($data_to_secure);

            $message = [
                'event' => 'assigned',
                'type' => 'duty',
                'to' => 'account',
                'encrypted' => $secure_data
            ];

            Redis::publish('events', json_encode($message));

            history()->log(
                'Assignment',
                'assigned ' . $account->format_full_name() . ' to duty: "' . $duty->label . '"',
                $account->id,
                'cube',
                'bg-olive'
            );
        }
    }
}
