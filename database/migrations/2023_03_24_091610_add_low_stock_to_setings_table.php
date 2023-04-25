<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLowStockToSetingsTable extends Migration
{

    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('low_stock_alert')->nullable();
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('low_stock_alert');
        });
    }
}
