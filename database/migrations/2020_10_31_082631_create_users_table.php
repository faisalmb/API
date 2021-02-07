<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id',300)->unique();
            $table->text('fullname');
            $table->string('phone',20);
            $table->text('email')->nullable();
            $table->string('password',300)->nullable();
            $table->string('recover',300)->nullable();
            $table->string('token',300)->nullable();
            $table->boolean('IsActive')->default(true);
            $table->boolean('IsSuperAdmin')->default(false);
            $table->boolean('IsConfirmedPhone')->default(false);
            $table->boolean('IsConfirmedEmaile')->default(false);
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->unsignedBigInteger('otp')->nullable();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
