<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('staff_id')->unique();
            $table->string('phone_no');
            $table->string('gender')->nullable();
            $table->string('branch');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('user_role',['cashier','admin'])->default('cashier');
            $table->enum('user_status',['deactivated','activated'])->default('activated');
            $table->rememberToken();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('users');
    }
}
