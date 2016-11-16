<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Events\Event;


class AccountCreated extends Event implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var Account
     */
    public $account;

    /**
     * AccountCreated constructor.
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        Log::info('Account Created:', [
            'id' => $account->id,
            'identifier' => $account->identifier,
            'username' => $account->username,
            'name' => $account->format_full_name(true)
        ]);
        $trans = $account->toArray();
        $trans['name_full'] = $account->format_full_name(true);
        $this->account = json_encode($trans);

        if (auth()->user()) {
            history()->log(
                'Account',
                'created a new account for ' . $account->format_full_name() . ' [' . $account->identifier . ']',
                $account->id,
                'user',
                'bg-green'
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
