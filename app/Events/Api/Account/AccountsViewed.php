<?php

namespace App\Events\Api\Account;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;
use App\Events\Event;

class AccountsViewed extends Event
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $accountIds;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($accountIds = [])
    {
        if ($user = auth()->user()) {
            Log::info($user->name . ' viewed ' . count($accountIds) . ' accounts', $accountIds);

            history()->log(
                'Account',
                'viewed ' . count($accountIds) . ' accounts',
                $user->id,
                'eye',
                'bg-aqua'
            );

        } else {
            Log::info('System viewed ' . count($accountIds) . ' accounts', $accountIds);
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
