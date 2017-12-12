<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use App\Http\Models\API\School;
use Illuminate\Support\Facades\Log;
use App\Events\Event;
use Illuminate\Support\Facades\Redis;
use Krucas\Settings\Facades\Settings;


class AssignedSchool extends Event
{
    /**
     * AssignedSchool constructor.
     * @param Account $account
     * @param School $school
     */
    public function __construct(Account $account, School $school)
    {
        $logMessage = 'assigned account to school - ';
        $logContext = [
            'action' => 'assignment',
            'model' => 'account',
            'pivot' => 'school',
            'account_id' => $account->id,
            'account_identifier' => $account->identifier,
            'account_username' => $account->username,
            'account_name_first' => $account->name_first,
            'account_name_last' => $account->name_last,
            'account_name' => $account->format_full_name(true),
            'account_created' => $account->created_at,
            'account_updated' => $account->updated_at,
            'school_id' => $school->id,
            'school_code' => $school->code,
            'school_label' => $school->label,
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
                        'school' => $school->toArray()
                    ],
                    'conf' => [
                        'ldap' => ldap_config()
                    ]
                ]);

                $secure_data = encrypt_broadcast_data($data_to_secure);

                $message = [
                    'event' => 'assigned',
                    'type' => 'school',
                    'to' => 'account',
                    'encrypted' => $secure_data
                ];

                Redis::publish('events', json_encode($message));
            }

            history()->log(
                'Assignment',
                'enrolled ' . $account->format_full_name() . ' in school: "' . $school->label . '"',
                $account->id,
                'university',
                'bg-olive'
            );
        }

        Log::info($logMessage, $logContext);
    }
}
