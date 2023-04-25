<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtorDetailsTable extends Migration
{

    public function up()
    {
        Schema::create('debtor_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('debtor_id');
            $table->string('debtor_number');
            $table->decimal('initial_payment', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount', 10, 2)->nullable();
            $table->string('payment_date')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('debtor_details');
    }
}
