<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryReStockHistoriesTable extends Migration
{

    public function up()
    {
        Schema::create('inventory_re_stock_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained();
            $table->unsignedBigInteger('quantity');
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('branch_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_re_stock_histories');
    }
}
