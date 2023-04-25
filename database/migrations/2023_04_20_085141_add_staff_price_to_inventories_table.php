<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStaffPriceToInventoriesTable extends Migration
{

    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->decimal('staff_price', 10, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('staff_price');
        });
    }
}




