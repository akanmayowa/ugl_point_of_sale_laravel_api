<?php /** @noinspection ALL */

namespace App\Listeners;

use App\Events\InventoryReStockHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreInventoryRestockHistory
{

    public function __construct()
    {

    }

    public function handle(InventoryReStockHistory $event)
    {
        $quantity = $event->quantity;
        $inventory = $event->inventory;
        $price = $event->price;
        $branch_id = $event->branch_id;
        $inventory->inventoryReStockHistory()->create([ 'quantity' => $quantity, 'price' => $price, 'branch_id' => $branch_id]);
        return true;
    }
}
