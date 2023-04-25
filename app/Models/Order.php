<?php

namespace App\Models;

use App\Enums\OrderStatusEnums;
use App\Enums\PaymentTypeEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'status' => OrderStatusEnums::class,
        'payment_type' => PaymentTypeEnums::class,
    ];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'order_id', 'id',);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function debtor()
    {
        return $this->belongsTo(Debtor::class, 'order_number', 'order_number');
    }


}
