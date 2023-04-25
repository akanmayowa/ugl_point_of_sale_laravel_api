<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitOfMeasurementToInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (!Schema::hasColumn('inventories', 'unit_of_measurement')) {
                $table->string('unit_of_measurement')->nullable();
            }
        });
    }


    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('unit_of_measurement');
        });
    }
}
