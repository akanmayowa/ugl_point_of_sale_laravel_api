<?php

namespace App\Events;

use App\Models\Inventory;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InventoryStock
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $inventory;
    public $currentQuantity;

    public function __construct(Inventory $inventory, $currentQuantity)
    {
        $this->inventory = $inventory;
        $this->currentQuantity = $currentQuantity;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
