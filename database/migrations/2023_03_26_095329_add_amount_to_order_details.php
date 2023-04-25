<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountToOrderDetails extends Migration
{

    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->decimal('amount', 10, 2);
        });
    }


    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn('amount');
        });
    }
}
