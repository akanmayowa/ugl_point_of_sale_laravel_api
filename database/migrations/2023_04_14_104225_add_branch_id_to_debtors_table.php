<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchIdToDebtorsTable extends Migration
{

    public function up()
    {
        Schema::table('debtors', function (Blueprint $table) {
            if (!Schema::hasColumn('debtors', 'branch_id')) {
                $table->foreignId('branch_id')->nullable()->constrained();
            }
        });
    }

    public function down()
    {
        Schema::table('debtors', function (Blueprint $table) {
            $table->dropColumn('branch_id');
        });
    }
}
