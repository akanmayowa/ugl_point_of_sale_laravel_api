<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionModesTable extends Migration
{

    public function up()
    {
        Schema::create('transaction_modes', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_mode');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaction_modes');
    }
}
