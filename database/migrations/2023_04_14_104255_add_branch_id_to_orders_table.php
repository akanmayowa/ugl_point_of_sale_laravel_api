<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchIdToOrdersTable extends Migration
{

    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'branch_id')) {
                $table->foreignId('branch_id')->nullable()->constrained();
            }
        });
    }


    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('branch_id');
        });
    }
}
