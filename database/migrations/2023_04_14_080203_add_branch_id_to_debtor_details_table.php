<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchIdToDebtorDetailsTable extends Migration
{

    public function up()
    {
        Schema::table('debtor_details', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained();
        });
    }

    public function down()
    {
        Schema::table('debtor_details', function (Blueprint $table) {
            $table->dropColumn('branch_id');
        });
    }
}
