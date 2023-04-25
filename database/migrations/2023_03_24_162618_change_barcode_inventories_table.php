<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBarcodeInventoriesTable extends Migration
{

    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('barcode', 200)->change()->nullable();
        });
    }

    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('bar_code');
        });
    }
}
