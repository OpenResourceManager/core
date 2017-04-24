<?php

namespace App\Events\Api\ServiceAccount;

use App\Events\Event;
use App\Http\Models\API\ServiceAccount;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class ServiceAccountViewed extends Event
{

    /**
     * ServiceAccountViewed constructor.
     * @param ServiceAccount $account
     */
    public function __construct(ServiceAccount $account)
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo broadcast view event
            }

            history()->log(
                'ServiceAccount',
                'viewed service account: ' . $account->username,
                $account->id,
                'fa-magic',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed service account: ' . $account->username);

    }
}