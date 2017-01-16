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

class AccountUpdated extends Event implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var Account
     */
    public $account;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Account $account)
    {
        Log::info('Account Updated:', [
            'id' => $account->id,
            'identifier' => $account->identifier,
            'username' => $account->username,
            'name' => $account->format_full_name(true)
        ]);

        $trans = $account->toArray();
        $trans['name_full'] = $account->format_full_name(true);
        $trans['username'] = strtolower($trans['username']);
        $this->account = json_encode($trans);

        if (auth()->user()) {
            history()->log(
                'Account',
                'updated an account for ' . $account->format_full_name() . ' [' . $account->identifier . ']',
                $account->id,
                'user',
                'bg-blue'
            );
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('account-events');
    }
}
