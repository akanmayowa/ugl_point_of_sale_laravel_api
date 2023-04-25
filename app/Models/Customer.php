<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function customerType()
   {
       return $this->hasOne(CustomerType::class, 'id', 'customer_type_id');
   }

   public function businessSegment()
   {
       return $this->hasOne(BusinessSegment::class, 'id', 'business_segment_id');
   }

   public function transaction()
   {
       return $this->hasMany(Transaction::class, 'customer_id', 'id');
   }

   public function order()
   {
       return $this->hasMany(Order::class, 'customer_id', 'id');
   }

   public function firstRecord($parameter)
   {
       return $this->where('id', $parameter)->with('customerType')->firstOrFail();
   }



}
