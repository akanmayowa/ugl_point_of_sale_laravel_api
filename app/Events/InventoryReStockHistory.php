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

class InventoryReStockHistory
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $inventory;
    public $quantity;
    public $price;
    public $branch_id;

    public function __construct(Inventory $inventory, $quantity, $price, $branch_id)
    {
        $this->inventory = $inventory;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->branch_id = $branch_id;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
