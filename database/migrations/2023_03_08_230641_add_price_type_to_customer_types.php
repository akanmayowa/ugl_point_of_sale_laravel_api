<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceTypeToCustomerTypes extends Migration
{

    public function up()
    {
        Schema::table('customer_types', function (Blueprint $table) {
            $table->unsignedBigInteger('price_type')->nullable();
        });
    }

    public function down()
    {
        Schema::table('customer_types', function (Blueprint $table) {
            $table->dropColumn('price_type');
        });
    }
}
