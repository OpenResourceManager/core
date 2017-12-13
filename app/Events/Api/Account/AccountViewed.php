<?php

namespace App\Events\Api\Account;

use App\Events\Api\ApiRequestEvent;
use Illuminate\Support\Facades\Log;
use App\Http\Models\API\Account;
use Krucas\Settings\Facades\Settings;

class AccountViewed extends ApiRequestEvent
{

    /**
     * AccountViewed constructor.
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        parent::__construct();

        $logMessage = 'viewed account - ';
        $logContext = [
            'action' => 'update',
            'model' => 'account',
            'account_id' => $account->id,
            'account_identifier' => $account->identifier,
            'account_username' => $account->username,
            'account_name_first' => $account->name_first,
            'account_name_last' => $account->name_last,
            'account_name' => $account->format_full_name(true),
            'account_created' => $account->created_at,
            'account_updated' => $account->updated_at,
            'requester_id' => 0,
            'requester_name' => 'System',
            'requester_ip' => getRequestIP(),
            'request_proxy_ip' => getRequestIP(true),
            'request_method' => \Request::getMethod(),
            'request_url' => \Request::fullUrl(),
            'request_uri' => \Request::getRequestUri(),
            'request_scheme' => \Request::getScheme(),
            'request_host' => \Request::getHost()
        ];

        if ($user = auth()->user()) {

            $logMessage = auth()->user()->name . ' ' . $logMessage;
            $logContext['requester_id'] = auth()->user()->id;
            $logContext['requester_name'] = auth()->user()->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo broadcast view event
            }

            history()->log(
                'Account',
                'viewed ' . $account->format_full_name() . '\'s account [' . $account->identifier . ']',
                $account->id,
                'user-circle',
                'bg-aqua'
            );
        }

        Log::info($logMessage, $logContext);
    }
}