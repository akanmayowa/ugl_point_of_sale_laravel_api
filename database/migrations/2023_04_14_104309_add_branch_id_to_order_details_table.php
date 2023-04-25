<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchIdToOrderDetailsTable extends Migration
{

    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            if (!Schema::hasColumn('order_details', 'branch_id')) {
                $table->foreignId('branch_id')->nullable()->constrained();
            }
        });
    }


    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn('branch_id');
        });
    }
}
