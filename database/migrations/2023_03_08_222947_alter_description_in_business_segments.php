<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDescriptionInBusinessSegments extends Migration
{

    public function up()
    {
        Schema::table('business_segments', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });
    }


    public function down()
    {
        Schema::table('business_segments', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
        });
    }
}
