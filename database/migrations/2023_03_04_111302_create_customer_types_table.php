<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTypesTable extends Migration
{

    public function up()
    {
        Schema::create('customer_types', function (Blueprint $table) {
            $table->id();
            $table->string('types');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('customer_types');
    }
}
