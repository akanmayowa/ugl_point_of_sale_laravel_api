<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountPasswordToSettings extends Migration
{

    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
        $table->string('discount_password')->default('secret123456');
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('discount_password');
        });
    }
}
