<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public static function getLowStockLevelAlert(): int
    {
        return self::first()->low_stock_alert ?? 10;
    }

}
