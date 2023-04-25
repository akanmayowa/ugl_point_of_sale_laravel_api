<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtorsTable extends Migration
{

    public function up()
    {
        Schema::create('debtors', function (Blueprint $table) {
            $table->id();
            $table->string('debtor_number');
            $table->unsignedBigInteger('order_id');
            $table->string('order_number');
            $table->unsignedBigInteger('customer_id');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount', 10, 2)->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->string('payment_duration')->nullable();
            $table->string('payment_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('debtors');
    }
}
