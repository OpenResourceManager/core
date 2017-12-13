<?php

namespace App\Events\Api\LoadStatus;

use App\Events\Api\ApiRequestEvent;
use App\Http\Models\API\LoadStatus;
use Illuminate\Support\Facades\Log;
use Krucas\Settings\Facades\Settings;

class LoadStatusViewed extends ApiRequestEvent
{
    /**
     * LoadStatusViewed constructor.
     * @param LoadStatus $loadStatus
     */
    public function __construct(LoadStatus $loadStatus)
    {

        parent::__construct();

        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            if (Settings::get('broadcast-events', false)) {
                // @todo bc view event
            }

            history()->log(
                'LoadStatus',
                'viewed ' . $loadStatus->label . '.',
                $loadStatus->id,
                'cubes',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $loadStatus->label . '.');
    }
}