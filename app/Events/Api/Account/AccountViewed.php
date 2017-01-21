<?php

namespace App\Events\Api\Account;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Events\Event;
use Illuminate\Support\Facades\Log;
use App\Http\Models\API\Account;

class AccountViewed extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * AccountViewed constructor.
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $user_name = 'System';

        if ($user = auth()->user()) {

            $user_name = $user->name;

            history()->log(
                'Account',
                'viewed ' . $account->format_full_name() . '\'s account [' . $account->identifier . ']',
                $account->id,
                'user-circle',
                'bg-aqua'
            );
        }

        Log::info($user_name . ' viewed ' . $account->format_full_name() . '\'s account [' . $account->identifier . ']');

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     *
     * public function broadcastOn()
     * {
     * return new PrivateChannel('channel-name');
     * }
     */
}