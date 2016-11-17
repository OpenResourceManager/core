<?php

namespace App\Events\Api\Account;

use App\Http\Models\API\Account;
use App\Http\Models\API\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Events\Event;


class UnassignedRoom extends Event implements ShouldBroadcast
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
    public function __construct(Account $account, Room $room)
    {
        $info = [
            'account_id' => $account->id,
            'identifier' => $account->identifier,
            'username' => $account->username,
            'name' => $account->format_full_name(true),
            '$room_id' => $room->id,
            'room_number' => $room->room_number,
            'building_label' => $room->building->label
        ];

        Log::info('Account unassigned Room:', $info);

        $this->info = json_encode($info);

        if (auth()->user()) {
            history()->log(
                'Assignment',
                'unassigned ' . $account->format_full_name() . ' room ' . $room->room_number . ' in ' . $room->building->label,
                $account->id,
                'building',
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
        return new PrivateChannel('room-assignment');
    }
}
