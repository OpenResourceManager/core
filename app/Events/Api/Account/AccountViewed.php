<?php

namespace App\Events\Api\Account;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Events\Event;
use Illuminate\Support\Facades\Log;
use App\Http\Models\API\Account;

class AccountViewed extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Account $account)
    {
        if ($user = auth()->user()) {
            Log::info($user->name . ' viewed ' . $account->format_full_name() . '\'s account [' . $account->identifier . ']');
            history()->log(
                'Account',
                'viewed ' . $account->format_full_name() . '\'s account [' . $account->identifier . ']',
                $account->id,
                'eye',
                'bg-aqua'
            );
        } else {
            Log::info('System viewed ' . $account->format_full_name() . '\'s account [' . $account->identifier . ']');
        }
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