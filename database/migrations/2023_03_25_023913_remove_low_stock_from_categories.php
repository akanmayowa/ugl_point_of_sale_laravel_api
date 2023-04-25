<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveLowStockFromCategories extends Migration
{

    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('low_stock_alert');
        });
    }


    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
        });
    }
}
