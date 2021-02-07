<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_users', function (Blueprint $table) {
            $table->string('id',300)->unique();
            $table->string('user_id',300);
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('branch_id',300);
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->boolean('IsActive')->default(true);
            $table->boolean('IsAdmin')->default(false);
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
        Schema::dropIfExists('branch_users');
    }
}
