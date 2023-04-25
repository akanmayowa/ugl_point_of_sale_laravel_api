<?php

namespace App\Listeners;

use App\Events\InventoryStock;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class UpdateInventoryStock
{

    public function __construct()
    {
        //
    }


    public function handle(InventoryStock $event)
    {
        $Inventory = $event->inventory;
        $currentQuantity = $event->currentQuantity;
        $Inventory->update([ 'quantity' => $currentQuantity]);
        return true;
    }
}
