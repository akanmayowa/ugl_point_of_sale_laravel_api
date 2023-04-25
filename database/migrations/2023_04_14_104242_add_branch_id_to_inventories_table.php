<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchIdToInventoriesTable extends Migration
{

    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (!Schema::hasColumn('inventories', 'branch_id')) {
                $table->foreignId('branch_id')->nullable()->constrained();
               }
            });
    }


    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('branch_id');
        });
    }
}
