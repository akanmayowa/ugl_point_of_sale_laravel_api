<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{

    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('staff_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('transaction_mode_id');
            $table->datetime('transaction_date');
            $table->datetime('transaction_last_modified_date')->nullable();
            $table->string('description')->nullable();
            $table->decimal('amount', 10, 3);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
