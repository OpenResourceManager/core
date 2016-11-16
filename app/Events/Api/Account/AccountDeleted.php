<?php

namespace App\Events\Api\Account;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Events\Event;
use App\Http\Models\API\Account;
use Illuminate\Support\Facades\Log;

class AccountDeleted extends Event implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $account;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Account $account)
    {
        Log::info('Account Deleted:', [
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
                'deleted an account for ' . $account->format_full_name() . ' [' . $account->identifier . ']',
                $account->id,
                'user',
                'bg-red'
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
