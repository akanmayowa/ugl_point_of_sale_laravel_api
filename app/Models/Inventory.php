<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id', 'id');
    }

    public static function getFirstRecord($params)
    {
        return self::where('id', $params)->first();
    }

    protected function UnitOfMeasurement(): Attribute
    {
        return new Attribute(
            get:  fn ($value) => strtolower($value),
            set:  fn ($value) => strtolower($value),
        );
    }


    public function firstRecord($parameter)
    {
        return $this->where('id', $parameter)->firstOrFail();
    }

    public function inventoryReStockHistory()
    {
        return $this->hasOne(InventoryReStockHistory::class, 'inventory_id', 'id');
    }

    public function getInventoryWithCategory($search, $perPage)
    {
        return $this->with('categories:id,name')
                        ->orderBy('name', 'asc')
                        ->where('name', 'like', '%' . $search . '%')
                        ->paginate($perPage);
    }

}
