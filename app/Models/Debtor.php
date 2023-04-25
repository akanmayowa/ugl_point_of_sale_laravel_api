<?php

namespace App\Models;

use App\Enums\DebtorStatusEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debtor extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'status' => DebtorStatusEnums::class,
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id','id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id','id');
    }

    public function debtorDetails()
    {
        return $this->hasMany(DebtorDetail::class, 'debtor_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
