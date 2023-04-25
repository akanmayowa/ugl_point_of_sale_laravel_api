<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InventoryReStockHistory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function inventory(): belongsTo
    {
        return $this->belongsTo(Inventory::class, 'id', 'inventory_id');
    }
}
