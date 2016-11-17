<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use App\Http\Models\API\Duty;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Events\Event;


class UnassignedDuty extends Event implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var String
     */
    public $info;

    /**
     * AddressCreated constructor.
     * @param Account $account
     */
    public function __construct(Account $account, Duty $duty)
    {
        $info = [
            'account_id' => $account->id,
            'identifier' => $account->identifier,
            'username' => $account->username,
            'name' => $account->format_full_name(true),
            'duty_id' => $duty->id,
            'duty_code' => $duty->code,
            'duty_label' => $duty->label
        ];

        Log::info('Account unassigned Duty:', $info);

        $this->info = json_encode($info);

        if (auth()->user()) {
            history()->log(
                'Assignment',
                'unassigned ' . $account->format_full_name() . ' from duty: "' . $duty->label.'"',
                $account->id,
                'university',
                'bg-yellow'
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
        return new PrivateChannel('duty-membership');
    }
}
