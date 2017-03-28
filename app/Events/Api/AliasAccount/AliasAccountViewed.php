<?php

namespace App\Events\Api\AliasAccount;

use App\Events\Event;
use App\Http\Models\API\AliasAccount;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class AliasAccountViewed extends Event
{

    /**
     * AliasAccountViewed constructor.
     * @param AliasAccount $account
     */
    public function __construct(AliasAccount $account)
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo broadcast view event
            }

            history()->log(
                'AliasAccount',
                'viewed ' . $account->owner->format_full_name() . '\'s alias account [' . $account->username . ']',
                $account->id,
                'fa-id-card-o',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $account->owner->format_full_name() . '\'s alias account [' . $account->username . ']');

    }
}