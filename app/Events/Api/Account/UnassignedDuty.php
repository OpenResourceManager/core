<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use App\Http\Models\API\Duty;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Krucas\Settings\Facades\Settings;


class UnassignedDuty extends Event
{
    /**
     * UnassignedDuty constructor.
     * @param Account $account
     * @param Duty $duty
     */
    public function __construct(Account $account, Duty $duty)
    {
        $logMessage = 'unassigned account from duty - ';
        $logContext = [
            'action' => 'unassignment',
            'model' => 'account',
            'pivot' => 'duty',
            'account_id' => $account->id,
            'account_identifier' => $account->identifier,
            'account_username' => $account->username,
            'account_name_first' => $account->name_first,
            'account_name_last' => $account->name_last,
            'account_name' => $account->format_full_name(true),
            'account_created' => $account->created_at,
            'account_updated' => $account->updated_at,
            'duty_id' => $duty->id,
            'duty_code' => $duty->code,
            'duty_label' => $duty->label,
            'requester_id' => 0,
            'requester_name' => 'System'
        ];

        if ($user = auth()->user()) {

            $logMessage = auth()->user()->name . ' ' . $logMessage;
            $logContext['requester_id'] = auth()->user()->id;
            $logContext['requester_name'] = auth()->user()->name;

            if (Settings::get('broadcast-events', false)) {

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
                    'event' => 'unassigned',
                    'type' => 'duty',
                    'to' => 'account',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Assignment',
                'unassigned ' . $account->format_full_name() . ' from duty: "' . $duty->label . '"',
                $account->id,
                'cube',
                'bg-yellow'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
