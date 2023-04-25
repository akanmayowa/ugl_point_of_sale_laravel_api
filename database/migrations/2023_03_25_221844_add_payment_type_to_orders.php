<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentTypeToOrders extends Migration
{

    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_type',['complete-payment', 'on-credit'])->default('complete-payment');
        });
    }


    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_type');
        });
    }
}
