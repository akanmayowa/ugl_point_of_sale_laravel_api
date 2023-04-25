<?php

namespace Database\Seeders;

use App\Enums\OrderStatusEnums;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Transaction;
use App\Models\TransactionMode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrdersAndTransactionSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $customer = Customer::first();
        $counter = 0;
        while ($counter <= 4) {
          $order_number =  'UGL-ORDER-'.random_int(1,100000);
           $order = Order::create([
               'order_number' => $order_number,
                'customer_id' => $customer->id,
                'subtotal' => 1000,
                'total' => 20000,
                'discount' => 0,
                'tax' => 0,
                'loyalty_discount' => 0,
                'staff_id' => $user->staff_id,
                'user_id' => $user->id,
                'order_date' => Carbon::now(),
                'status' => OrderStatusEnums::Pending,
               'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $this->orderDetails($order);
            $this->transaction($customer,$order, $user);
            $counter++;
        }
    }

    public function orderDetails($order)
    {
        $inventory = Inventory::first();
        $data = [
            'order_id' => $order->id,
            'inventory_id' => $inventory->id,
            'quantity' => 3,
            'price' => 4000,
        ];
        OrderDetail::create($data);
    }

    public function transaction($customer,$order, $user){
        $data = [
            'reference_number' => 'UGL-TRN'.random_int(10,10000000),
            'user_id' => $user->id,
            'staff_id' => $user->staff_id,
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'transaction_mode_id' => TransactionMode::first()->id,
            'transaction_date' => Carbon::now(),
            'amount' => $order->total,
        ];
        Transaction::create($data);
    }

}
