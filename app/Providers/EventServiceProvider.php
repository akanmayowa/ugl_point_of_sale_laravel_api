<?php

namespace App\Providers;

use App\Events\InventoryReStockHistory;
use App\Events\InventoryStock;
use App\Events\Stocks;
use App\Listeners\StoreInventoryRestockHistory;
use App\Listeners\StoreStock;
use App\Listeners\UpdateInventoryStock;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        InventoryStock::class => [
            UpdateInventoryStock::class,
        ],

        InventoryReStockHistory::class => [
            StoreInventoryRestockHistory::class,
        ]
    ];


    public function boot()
    {
        //
    }
}
