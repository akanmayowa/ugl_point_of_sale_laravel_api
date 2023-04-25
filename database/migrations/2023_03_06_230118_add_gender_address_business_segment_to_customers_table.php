<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenderAddressBusinessSegmentToCustomersTable extends Migration
{

    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('gender')->default('male');
            $table->string('address', 200)->nullable();
            $table->unsignedBigInteger('business_segment_id')->default(1);
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['gender','address', 'business_segment_id']);
        });
    }
}
