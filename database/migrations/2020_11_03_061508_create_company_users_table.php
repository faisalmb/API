<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_users', function (Blueprint $table) {
            $table->string('id',300)->unique();
            $table->string('user_id',300);
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('company_id',300);
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('company_users');
    }
}
