<?php

namespace Database\Seeders;

use App\Enums\PaymentTypeEnums;
use App\Models\Debtor;
use App\Models\Order;
use App\Models\PaymentDuration;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DebtorSeeder extends Seeder
{
    /**
     * @throws \Exception
     */
    public function run()
    {
        $payment = PaymentDuration::first();
        $counter = 0;
        while ($counter <= 4) {
            Debtor::create([
                'debtor_number' => 'UGL-DB'.random_int(10,10000000),
                'order_id' => $this->orders(1)->id,
                'order_number' => $this->orders(1)->order_number,
                'customer_id' => 1,
                'first_deposit' => 4000,
                'total_amount' => 10000,
                'discount' => 1000,
                'payment_duration' => $payment->duration,
                'status' => PaymentTypeEnums::Open,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            Debtor::create([
                'debtor_number' => 'UGL-DB'.random_int(10,10000000),
                'order_id' => $this->orders(2)->id,
                'order_number' => $this->orders(2)->order_number,
                'customer_id' => 1,
                'first_deposit' => 4000,
                'total_amount' => 10000,
                'discount' => 200,
                'payment_duration' => $payment->duration,
                'status' => PaymentTypeEnums::Open,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            Debtor::create([
                'debtor_number' => 'UGL-DB'.random_int(10,10000000),
                'order_id' => $this->orders(3)->id,
                'order_number' => $this->orders(3)->order_number,
                'customer_id' => 3,
                'first_deposit' => 6000,
                'total_amount' => 30000,
                'discount' => 500,
                'payment_duration' => $payment->duration,
                'status' => PaymentTypeEnums::Open,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            Debtor::create([
                'debtor_number' => 'UGL-DB'.random_int(10,10000000),
                'order_id' => $this->orders(4)->id,
                'order_number' => $this->orders(4)->order_number,
                'customer_id' => 4,
                'first_deposit' => 5000,
                'total_amount' => 20000,
                'discount' => 7000,
                'payment_duration' => $payment->duration,
                'status' => PaymentTypeEnums::Open,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $counter++;
        }
    }


    public function orders(int $id)
    {
        return Order::where('id', $id)->firstOrFail();
    }



}
